<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Landlord;
use App\Models\Property;
use App\Models\PropertyTenant;
use App\Models\Tenant;
use App\User;
use Auth;
use Carbon\Carbon as Carbon;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends AdminController
{


    public function postGetUser()
    {
        if (Auth::user()) {
            dd(Auth::user());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param $user
     *
     * @return Response
     */
    public function postEdit(UserEditRequest $request, $id)
    {

        $user = User::find($id);
        $user->name = $request->name;
        $user->confirmed = $request->confirmed;

        $password = $request->password;
        $passwordConfirmation = $request->password_confirmation;

        if (!empty($password)) {
            if ($password === $passwordConfirmation) {
                $user->password = bcrypt($password);
            }
        }
        $user->save();
    }

    /**
     * Get a json containing all users visible to the current user.
     *
     * @param int $id
     * @param boolean $all return all kinds of data if true or just the users if false
     *
     * @return \Illuminate\Http\JsonResponse|static
     */
    public function getVisibleUsers($id = 0, $all = false)
    {

        $properties = $this->getRelatedProperties($id);
        if (count($properties) <= 0) {
            return response()->json(['success' => 0]);
        }

        $return = collect();
        // Find all neighbours for all assigned properties.
        foreach ($properties as $property) {
            $return = $return->merge($property->tenantsAsUsers);
            // Also add the landlord of each property.
            $return = $return->merge([User::find($property->user_id)]);
        }

        $return = $return->unique('id');

        foreach ($return as $user) {
            $user['profile'] = $user->profile;
        }

        if (!$all) {
            return $return;
        } else {
            return response()->json(['u' => $return, 'p' => $properties]);
        }
    }

    /**
     * Alias function for getVisibleUsers in order to retrieve all data
     * @return static
     */
    public function getRecipients()
    {
        return $this->getVisibleUsers(0, true);
    }

    public function getRelatedProperties($id = 0)
    {
        if ($id == 0) {
            $id = Auth::user()->id;
        }
        $user = User::findOrFail($id);

        // Find all associated properties
        $properties = collect();
        // Administrator
        if ($user->hasRole('Administrator')) {
            $properties = $properties->merge(Property::all());
        }
        // Tenant
        if ($user->hasRole('Tenant')) {
            $properties = $properties->merge(Tenant::find($id)->properties);
        }
        // Landlord
        if ($user->hasRole('Landlord')) {
            $properties = $properties->merge(Landlord::find($id)->properties);
        }

        // Flatten the collection
        return $properties->flatten();
    }

    /**
     * @Todo needs update
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUserProfile()
    {
        $user = User::with('roles', 'profile')->find(Auth::user()->id);
        $landlord = 0;
        $tenant = 0;
        foreach ($user->roles as $role) {
            if($role['name'] == 'Landlord') {
                $landlord = 1;
            }
            if($role['name'] == 'Tenants'){
                $tenant = 0;
            }
        }
        $user->cnt_properties = null;
        if ($landlord == 1) {
            $user->cnt_properties = Property::where('user_id', $user->id)->count();
        } elseif ($tenant == 1) {
            $user->cnt_properties = PropertyTenant::where('user_id', $user->id)->count();
        }

        return response()->json($user);
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUserData()
    {
        $user = User::with('profile.currency')->find(Auth::user()->id);
        $roles = $user->role;
        $userRole = [];
        $normal = 0;
        $deposit = 0;
        $guest = 0;

        foreach ($roles as $key =>$value) {
            if($value->slug == 'depositrelay'){
                $deposit = 1;
            } else if($value->slug == 'guest') {
                $guest = 1;
            }else {
                $normal = 1;
            }
            $userRole[] = $value->slug;
        }
        if(!$user->last_login){
            $checkRoles = $this->getRoleMethod($user);
            if (in_array('landlord', $checkRoles)) {
                $guest = 1;
                $normal = 0;
                $deposit =0;
            }
            $currentTime = Carbon::now();
            $user->last_login =$currentTime->toDateTimeString();
            $user->save();
        }

        unset($user->password);
        unset($user->confirmation_code);
        unset($user->remember_token);
        $data = [
            'user' =>$user,
            'roles' => $userRole,
            'normal' => $normal,
            'deposit' =>$deposit,
            'guest' => $guest,
            'lang' => \Session::get('locale')
        ];
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUserProperties()
    {
        return response()->json(Property::where('user_id', Auth::user()->id)->where('status','>',0)->whereNull('parent_id')->lists('title', 'id'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUserPropertiesWithUnits()
    {
        return response()->json(Property::where('user_id', Auth::user()->id)->where('status','>',0)->whereNull('parent_id')->with('units')->get(['id','title']));
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSetFirstLogin()
    {
        $user = User::find(Auth::user()->id);
        $user->has_login = 1;
        if ($user->save()) {
            return response()->json(['status' => 1]);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCheckFirstLogin()
    {
        $user = User::find(Auth::user()->id);
        if ($user) {
            return response()->json(['status' => 1, 'hasLogin' => $user->has_login]);
        }
    }

    public function getTags()
    {
        $user = User::find(Auth::user()->id);
        if ($user) {
            return $user->tags;
        } else {
            return [];
        }
    }


    /**
     *
     * remove demo data from the user account - by default new users will load with demo data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUpdateDemo()
    {
        $user = User::find(Auth::user()->id);
        $user->has_demo = 0;
        if ($user->save()) {
            return response()->json(['status' => 1, 'has_demo' => 0]);
        }
    }

    public function getRoleMethod($user){
        return is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
    }

    public function postSetLanguages(Request $request){
        $langKey = $request->get('langKey');
        \Session::put('locale', $langKey);
        \App::setLocale($langKey);
        return response()->json(['status' => 0]);
    }
}
