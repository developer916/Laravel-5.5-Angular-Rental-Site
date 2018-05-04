<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests;
use App\Http\Services\PropertyService;
use App\Http\Services\TenantService;
use App\Http\Services\TransactionService;
use App\Models\PropertyFinancial;
use App\Models\PropertyTenant;
use App\Models\PropertyTransaction;
use App\Models\PropertyUserTransaction;
use App\Models\Role;
use App\Models\Tenant;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;



class PropertyTenantController extends AdminController
{

    public function getTenant($propertyTenantId)
    {

        $propertyTenantId = (int)$propertyTenantId;
        $tenant = PropertyTenant::where('property_tenants.id', $propertyTenantId)
            ->join('users', function ($join) {
                $join->on('property_tenants.user_id', '=', 'users.id')
                    ->where('users.parent_id', '=', Auth::user()->id);
            })->get([
                'users.id',
                'users.name'
            ])->first();
        return response()->json($tenant);
    }

    /**
     * Get tenants grid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTenants(PropertyService $service, $propertyId = null)
    {
        $tenantsRequest = [];
        $propertyTenants = $service->getTenants($propertyId)['data'];


        foreach ($propertyTenants as $propertyTenant) {
            $sameProperty = true;
            if ($propertyTenant->property_id != $propertyId) {
                $sameProperty = false;
            }
            $tenantsRequest[] = [
                'cnt' => '',
                'id' => ($sameProperty) ? $propertyTenant->tenant_id : null,
                'collection_day' => ($sameProperty) ? $propertyTenant->collection_day : null,
                'start_date' => ($sameProperty && $propertyTenant->start_date) ? Carbon::createFromFormat('Y-m-d H:i:s',
                    $propertyTenant->start_date)->toDateString() : null,
                'end_date' => ($sameProperty && $propertyTenant->end_date) ? Carbon::createFromFormat('Y-m-d H:i:s',
                    $propertyTenant->end_date)->toDateString() : null,
                'unit_id' => ($sameProperty) ? $propertyTenant->unit_id : null,
                'unit' => ($sameProperty) ? $propertyTenant->unit : null,
                'property_id' => $propertyId,
                'tenant' => [
                    'id' => $propertyTenant->tenant_id,
                    'name' => $propertyTenant->name,
                    'email' => $propertyTenant->email
                ],
                'actions' => ''
            ];
        }
        return response()->json([
            'data' => $tenantsRequest,
            'recordsFiltered' => count($tenantsRequest),
            'draw' => 1,
            'recordsTotal' => count($tenantsRequest)
        ]);
    }

    public function getUserTransactions(TransactionService $service, $propertyTenantId)
    {
        $transactions = $service->getUserTransactionByPropertyTenant($propertyTenantId)['data'];
        return response()->json([
            'data' => $transactions,
            'recordsFiltered' => count($transactions),
            'draw' => 1,
            'recordsTotal' => count($transactions)
        ]);
    }

    public function  getDeleteUserTransaction(TransactionService $service, $id)
    {
        return response()->json($service->deleteUserTransaction($id));
    }

    public function  postCreateUpdateUserTransaction(TransactionService $service)
    {
        return response()->json($service->saveUserTransaction());
    }


    public function postSearchByName()
    {
        $list = Tenant::where('parent_id', '>', 0)->where('name', 'LIKE',
            Input::get('term') . '%')->get();
        return response()->json($list);
    }

    public function postCreate(TenantService $service)
    {
        return response()->json($service->propertyTenantAssign());
    }

    /**
     * Creates and udates propertyTenant
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateUpdate(TenantService $tenantService)
    {
        return response()->json($tenantService->propertyTenantSaveAndAssign());
    }


}
