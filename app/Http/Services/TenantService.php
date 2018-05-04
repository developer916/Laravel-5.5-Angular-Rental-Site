<?php
namespace App\Http\Services;

use App\Events\TenantWasAssigned;
use App\Events\TenantWasCreated;
use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Models\PropertyTenant;
use App\Models\Tenant;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;


class TenantService
{

    protected $request;

    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
    }

    public function save()
    {
        $tenantRequestData = $this->request->all();
        $errors = [];
        $tenant = null;
        if (!isset($tenantRequestData['tenant']['name']) || !$tenantRequestData['tenant']['name']) {
            $errors = [
                'tenant' => new MessageBag(['name' => trans('tenant.enter_name')])
            ];
        }
        if (!isset($tenantRequestData['tenant']['email']) || !$tenantRequestData['tenant']['email']) {
            $errors = [
                'tenant' => new MessageBag(['email' => trans('tenant.enter_email')])
            ];
        }
        if ($errors) {
            $tenantRequestData['errors'] = $errors;

            return [
                'status' => 0,
                'data' => $tenantRequestData
            ];
        }
        if (isset($tenantRequestData['tenant']['id']) && $tenantRequestData['tenant']['id'])
        {
            $tenant = Tenant::where('id', $tenantRequestData['tenant']['id'])->first();
            if ($tenant) {
                if (isset($tenantRequestData['tenant']['email']) && $tenant->email != $tenantRequestData['tenant']['email']) {
                    if (!Tenant::where('email', $tenantRequestData['tenant']['email'])->exists()) {
                        $tenant->email = $tenantRequestData['tenant']['email'];
                    } else {
                        $errors = [
                            'tenant' => new MessageBag(['email' => trans('tenant.email_assigned')])
                        ];
                    }
                }
                $tenant->name = $tenantRequestData['tenant']['name'];
                if ($tenant->isDirty() && $tenant->validate($tenant->id)) {
                    $tenant->save();
                }
            }
        } else {
            if (Tenant::where('email', $tenantRequestData['tenant']['email'])->exists()) {
                $errors = [
                    'tenant' => new MessageBag(['email' => trans('tenant.email_assigned')])
                ];
            } else {
                $tenant = new Tenant();
                $tenant->fill([
                    'name' => isset($tenantRequestData['tenant']['name']) ? $tenantRequestData['tenant']['name'] : null,
                    'parent_id' => Auth::user()->id,
                    'email' => isset($tenantRequestData['tenant']['email']) ? $tenantRequestData['tenant']['email'] : null,
                    'password' => bcrypt(md5(time())),
                    'confirmed' => 1,
                    'admin' => 0,
                    'confirmation_code' => str_random(32)
                ]);
                if ($tenant->validate())
                {
                    $tenant->save();
                    $tenantProperty1On1=0;
                    if(Property::where('user_id', Auth::user()->id)->where('status', 1)->whereNull('parent_id')->count()==1 and \DB::table('users')->where('users.parent_id', Auth::user()->id)->whereNull('users.deleted_at')->count()==1){
                        $property_id=Property::where('user_id', Auth::user()->id)->where('status', 1)->whereNull('parent_id')->first()->id;

                        $propertyTenant=$this->createPropertyTenant($tenant->id,array("property_id"=>$property_id,
                                                                        "start_date"=>Carbon::now()->format('Y-m-d'),
                                                                        'collection_day'=>1,
                                                                        'end_date'=>Carbon::now()->addYear()->format('Y-m-d')));
                        if ($propertyTenant->validate()) {
                            $propertyTenant->save();
                            $tenantProperty1On1=1;
                            Event::fire(new TenantWasAssigned($tenant, 'assign-tenant-email'));
                        }
                    }
                }
            }
        }
        if ($tenant) {
            $tenantRequestData['tenant'] = [
                'id' => $tenant->id,
                'name' => $tenant->name,
                'email' => $tenant->email,
                'tenantProperty1On1'=>$tenantProperty1On1
            ];
            if (isset($tenant['errors'])) {
                $errors['tenant'] = $tenant['errors'];
            }
        }
        $tenantRequestData['errors'] = ($errors) ? $errors : null;
        return [
            'status' => ($errors) ? 0 : 1,
            'data' => $tenantRequestData
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function delete($id)
    {
        $assigned = PropertyTenant::where('user_id', $id)->get();
        $tenant = Tenant::find($id);
        if ($assigned) {
            PropertyTenant::where('user_id', $id)->delete();
        }
        if ($tenant) {
            $tenant->delete();
            return ['status' => 1];
        }
        return ['status' => 0];
    }


    public function view($id)
    {
        if (is_object($id) && $id instanceof Collection) {
            $tenant = $id;
        } else {
            $tenant = Tenant::where('id', $id)->with('profile')->first();
        }
        if ($tenant) {
            $tenant->property_tenant = PropertyTenant::where('user_id', $tenant->id)->whereRaw(
                'property_tenants.end_date > DATE(NOW())'
            )->with('property.photos')->orderBy('property_tenants.id', 'desc')->first();
        } else {
            $tenant->property_tenant = null;
        }
        $data = null;
        if ($tenant) {
            $data = [
                'id' => $tenant->id,
                'email' => $tenant->email,
                'name' => $tenant->name,
                'created_at' => $tenant->created_at->toDateTimeString(),
                'updated_at' => $tenant->updated_at->toDateTimeString(),
            ];
            if ($tenant->profile) {
                $data['profile'] = [
                    'phone' => $tenant->profile->phone,
                    'avatar' => $tenant->profile->avatar,
                    'currency_id' => $tenant->profile->currency_id,
                    'notifications' => $tenant->profile->notifications,
                    'created_at' => $tenant->profile->created_at,
                    'updated_at' => $tenant->profile->updated_at,
                ];
            } else {
                $data['profile'] = null;
            }
            if ($tenant->property_tenant) {
                unset($tenant->property_tenant->deleted_at);
                $propertyTenant = $tenant->property_tenant->toArray();
                if ($tenant->property_tenant->property) {
                    $photos = $tenant->property_tenant->property->photos;
                    $propertyTenant['property'] = [
                        'id' => $tenant->property_tenant->property->id,
                        'title' => $tenant->property_tenant->property->title,
                    ];
                    if ($photos) {
                        foreach ($photos as $photo) {
                            $propertyTenant['property']['photo'][] = [
                                'file' => $photo->file,
                                'file_size' => $photo->file_size
                            ];
                        }
                    } else {
                        $propertyTenant['property']['photos'] = null;
                    }
                }
                $data['property_tenant'] = $propertyTenant;
            } else {
                $data['property_tenant'] = null;
            }
        }
        return [
            'status' => 1,
            'data' => $data
        ];
    }


    /*
     *
     * You are entering in Property Tenant sektor
     *
     */

    public function propertyTenantSaveAndAssign()
    {
        $propertyTenantRequestData = $this->request->all();
        $propertyTenant = null;
        $tenant = null;
        $errors = [];
        if (isset($propertyTenantRequestData['status']) && isset($propertyTenantRequestData['id']) && $propertyTenantRequestData['id'] && $propertyTenantRequestData['status'] == -1) {
            PropertyTenant::where('id', $propertyTenantRequestData['id'])->delete();
            $propertyTenantRequestData['status'] = 0;
            return response()->json($propertyTenantRequestData);
        }
        if (isset($propertyTenantRequestData['tenant']['id']) && $propertyTenantRequestData['tenant']['id']) {
            /** @var Tenant $tenant */
            $tenant = Tenant::where('id', $propertyTenantRequestData['tenant']['id'])->first();
            if ($tenant) {
                //tenant data can be updated
                $tenant->name = isset($propertyTenantRequestData['tenant']['name']) ? $propertyTenantRequestData['tenant']['name'] : null;
                if (isset($propertyTenantRequestData['tenant']['email']) && $tenant->email != $propertyTenantRequestData['tenant']['email']) {
                    if (!Tenant::where('email',
                        $propertyTenantRequestData['tenant']['email'])->exists()
                    ) {
                        $tenant->email = $propertyTenantRequestData['tenant']['email'];
                    } else {
                        $errors = [
                            'tenant' => new MessageBag(['email' => trans('This email is already assigned!')])
                        ];
                    }
                }
                if ($tenant->isDirty() && $tenant->validate($tenant->id)) {
                    $tenant->save();
                }
                if (isset($propertyTenantRequestData['id']) && $propertyTenantRequestData['id']) {
                    $propertyTenant = $this->updatePropertyTenant($tenant->id,
                        $propertyTenantRequestData);
                    if ($propertyTenant && $propertyTenant->validate()) {
                        $propertyTenant->save();
                    }
                } else {
                    //if there is an property_id and no propertyTenant currently active, create new propertyTenant
                    if (isset($propertyTenantRequestData['property_id']) && !PropertyTenant::where('user_id',
                            $tenant->id)->where('end_date', '>', 'NOW()')->exists()
                    ) {
                        $propertyTenant = $this->createPropertyTenant($tenant->id,
                            $propertyTenantRequestData);
                        if ($propertyTenant->validate()) {
                            $propertyTenant->save();
                            Event::fire(new TenantWasAssigned($tenant, 'assign-tenant-email'));
                        }
                    } else {
                        $errors = [
                            'tenant' => new MessageBag(['general' => trans('Tenant already assigned!')])
                        ];
                    }
                }
            }
        } else {
            if (Tenant::where('email', $propertyTenantRequestData['tenant']['email'])->exists()) {
                $errors = [
                    'tenant' => new MessageBag(['email' => trans('This email is already assigned!')])
                ];
            } else {
                $tenant = new Tenant();
                $tenant->fill([
                    'name' => isset($propertyTenantRequestData['tenant']['name']) ? $propertyTenantRequestData['tenant']['name'] : null,
                    'parent_id' => Auth::user()->id,
                    'email' => isset($propertyTenantRequestData['tenant']['email']) ? $propertyTenantRequestData['tenant']['email'] : null,
                    'password' => bcrypt(md5(time())),
                    'confirmed' => 1,
                    'admin' => 0,
                    'confirmation_code' => str_random(32)
                ]);
                if ($tenant->validate()) {
                    $tenant->save();
                    Event::fire(new TenantWasCreated($tenant, 'invite-tenant-email'));
                    $propertyTenant = $this->createPropertyTenant($tenant->id, $propertyTenantRequestData);
                    $propertyTenantValid = $propertyTenant->validate();
                    if ($propertyTenantValid) {
                        $propertyTenant->save();
                    }
                    Event::fire(new TenantWasAssigned($tenant, 'assign-tenant-email'));
                }
            }
        }
        if ($propertyTenant) {
            $propertyTenantRequestData['id'] = $propertyTenant->id;
            if (isset($propertyTenant['errors'])) {
                $errors = array_merge($errors, $propertyTenant['errors']->toArray());
            }
        }
        if ($tenant) {
            $propertyTenantRequestData['tenant']['id'] = $tenant->id;
            if (isset($tenant['errors'])) {
                $errors['tenant'] = $tenant['errors'];
            }
        }
        $propertyTenantRequestData['errors'] = ($errors) ? $errors : null;
        $propertyTenantRequestData['status'] = ($errors) ? 1 : 0;
        return $propertyTenantRequestData;
    }

    public function propertyTenantAssign()
    {
        $propertyTenantRequestData = $this->request->all();
        $errors = null;
        if (!$propertyTenantRequestData['user_id']) {
            return ['status' => 0];
        }

        if (!isset($propertyTenantRequestData['property_id'])) {
            $errors = ['property_id' => [trans('Property is required!')]];
        }
        if ($errors) {
            $propertyTenantRequestData['errors'] = $errors;
            return [
                'status' => 0,
                'data' => $propertyTenantRequestData,
            ];
        }
        $isNewAssign = false;
        if (isset($propertyTenantRequestData['id']) && $propertyTenantRequestData['id']) {
            $propertyTenant = $this->updatePropertyTenant($propertyTenantRequestData['user_id'],
                $propertyTenantRequestData);
        } else {
            $propertyTenant = $this->createPropertyTenant($propertyTenantRequestData['user_id'],
                $propertyTenantRequestData);
            $isNewAssign = true;
        }
        if ($propertyTenant && $propertyTenant->validate()) {
            if ($propertyTenant->save()) {
                if ($isNewAssign) {
                    Event::fire(new TenantWasAssigned(Tenant::find($propertyTenantRequestData['user_id']), 'assign-tenant-email'));
                }
                return [
                    'status' => 1,
                    'data' => $propertyTenant
                ];
            }
        }
        return ['status' => 0];

    }

    public
    function propertyTenantDelete($id)
    {
        $propertyTenant = PropertyTenant::where('id', $id)->with('tenant')->first();
        if ($propertyTenant && Auth::user()->id == $propertyTenant->tenant->parent_id) {
            if ($propertyTenant->delete()) {
                return ['status' => 1];
            }
        }
        return ['status' => 0];
    }

    /**
     * @param $tenantId
     * @param $tenantRequestData
     * @return mixed
     */
    private
    function updatePropertyTenant($tenantId, $tenantRequestData)
    {
        /** @var PropertyTenant $propertyTenant */
        $propertyTenant = PropertyTenant::where('id', $tenantRequestData['id'])
            ->where('user_id', $tenantId)->first();
        if ($propertyTenant) {
            $propertyTenant->fill([
                'property_id' => $tenantRequestData['property_id'],
                'unit_id' => $tenantRequestData['unit_id'],
                'collection_day' => isset($tenantRequestData['collection_day']) ? $tenantRequestData['collection_day'] : null,
                'start_date' => isset($tenantRequestData['start_date']) ? $tenantRequestData['start_date'] : null,
                'end_date' => isset($tenantRequestData['end_date']) ? $tenantRequestData['end_date'] : null,
            ]);
        }
        return $propertyTenant;
    }

    /**
     * @param $tenantId
     * @param $tenantRequestData
     * @return mixed
     */
    private
    function createPropertyTenant($tenantId, $tenantRequestData)
    {
        $propertyTenant = new PropertyTenant();
        $propertyTenant->fill([
            'property_id' => $tenantRequestData['property_id'],
            'user_id' => $tenantId,
            'unit_id' => isset($tenantRequestData['unit_id']) ? $tenantRequestData['unit_id'] : null,
            'collection_day' => isset($tenantRequestData['collection_day']) ? $tenantRequestData['collection_day'] : null,
            'start_date' => isset($tenantRequestData['start_date']) ? $tenantRequestData['start_date'] : null,
            'end_date' => isset($tenantRequestData['end_date']) ? $tenantRequestData['end_date'] : null,
        ]);
        return $propertyTenant;
    }


}