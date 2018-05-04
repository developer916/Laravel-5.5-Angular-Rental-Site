<?php namespace App\Http\Controllers\Admin;

use App\Commands\CreateTenantCommand;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\TenantRequest;
use App\Http\Services\TenantService;
use App\Models\PropertyAmenity;
use App\Models\PropertyPhoto;
use App\Models\PropertyTenant;
use App\Models\Tenant;
use App\Models\Property;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;


/**
 * Class TenantController
 * @package App\Http\Controllers\Admin
 */
class TenantController extends AdminController
{
    /**
     * Get tenants grid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTenantsGrid()
    {

        // fetch all tenants
        $tenants = \DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->leftJoin('property_tenants', 'users.id', '=', 'property_tenants.user_id')
            ->leftJoin('properties', 'properties.id', '=', 'property_tenants.property_id')
            ->where('users.parent_id', Auth::user()->id)
            ->whereNull('users.deleted_at')
            // ->groupBy('users.id')
            ->get([
                'users.id',
                'name',
                'property_tenants.unit_id',
                'properties.title',
                'property_tenants.start_date',
                'property_tenants.end_date',
                'profiles.avatar'
            ]);

        foreach ($tenants as $tenant) {
            $tenant->unit = null;
            if ($tenant->unit_id) {
                $tenant->unit = Property::where('id', $tenant->unit_id)->pluck('unit');
            }
            if (isset($tenant->title)) {
                $tenant->hasProperty = $tenant->title;
            } else {
                $tenant->hasProperty = trans('tenant.not_assigned');
            }

            if (isset($tenant->start_date)) {
                $tenant->start_date = Carbon::parse($tenant->start_date)->formatLocalized('%d %B %Y');
            }

            $tenant->start_date = (isset($tenant->start_date) ? Carbon::parse($tenant->start_date)->formatLocalized('%d %B %Y') : '---');
            $tenant->end_date = (isset($tenant->end_date) ? Carbon::parse($tenant->end_date)->formatLocalized('%d %B %Y') : '---');
            $tenant->actions = tenantActions($tenant->id);
        }

        return response()->json([
            'data' => $tenants,
            'recordsFiltered' => sizeof($tenants),
            'draw' => 1,
            'recordsTotal' => sizeof($tenants)
        ]);
    }


    /**
     * Create single tenant
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateSingleTenant(TenantService $tenantService)
    {
        return response()->json($tenantService->save());
    }

    /**
     * Get tenant by ID
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTenant(TenantService $tenantService,$id)
    {
        return response()->json($tenantService->view($id));
    }


    /**
     * @param TenantRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSearchTenants(TenantRequest $request)
    {
        return response()->json(['items' => Tenant::where('name', 'LIKE', "%$request->term%")->get()]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTenantAssigned($id)
    {
        $assigned = PropertyTenant::where('user_id', $id)->count();

        return response()->json(['assignedTo' => $assigned]);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function getDeleteTenant(TenantService $tenantService, $id)
    {
        return response()->json($tenantService->delete($id));
    }


}
