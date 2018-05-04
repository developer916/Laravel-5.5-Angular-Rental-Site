<?php namespace App\Http\Controllers\Admin;

use App\Commands\CreateLandlordCommand;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\LandlordRequest;
use App\Models\Landlord;
use App\Models\Tenant;

class LandlordController extends AdminController
{
    public function postCreate(LandlordRequest $request)
    {
        $landlord = Landlord::where('email', $request->email)->first();

        if (!$landlord) {
            $this->dispatch(new CreateLandlordCommand($request->all()));
        }
    }

    public function getVisibleUsers($id = 0) {
        if ($id == 0)
            $id = Auth::user()->id;

        if (User::find($id)->hasRole('Landlord')) {
            $landlord = Landlord::find(Auth()->user()->id);
            $properties = $landlord->properties;

            return $properties;

            $return = collect();

            // Find all neighbours for all assigned properties.
            foreach ($properties as $property) {
                $return = $return->merge($property->tenants(true));
            }

            // Find your landlords TODO If additional landlords are allowed
            $return = $return->merge([Landlord::find($property->user_id)]);

            return $return;
        } else {
            return response()->json(['success' => 0]);
        }
    }

    public function getTenantsList()
    {
        return response()->json(Tenant::where('parent_id', \Auth::user()->id)->get([
            'users.id',
            'users.name'
        ]));
    }
}
