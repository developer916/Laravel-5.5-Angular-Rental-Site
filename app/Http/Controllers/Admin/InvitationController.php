<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Mail\landlordInvitation as mailLandlordInvitation;
use App\Mail\tenantInvitation as mailTenantInvitation;
use App\Models\Country;
use App\Models\LandlordInvitation;
use App\Models\TenantInvitation;
use Auth;
use App\Models\Property;
use App\Models\PropertyTenant;
use App\User;
use Illuminate\Http\Request;
use App\Models\RoleUser;
use Mail;
use App\Models\UserPromo;
use App\Models\Promo;
use Carbon\Carbon as Carbon;

class InvitationController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    static $RoomName = [
        'A','B','C','D','E','F'
    ];
    public function existTenants(Request $request){
        header('Access-Control-Allow-Origin: *');
        $tenants = $request->get('tenants');
        $data = array();
        $i = 0;
        foreach($tenants as $key => $tenant){
            $user = User::where('email', $tenant)->where('parent_id', '!=', '0')->first();
            if(count($user) >0) {
                $roles = is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
                if (in_array('tenant', $roles)) {
                    $data[$i]  = array();
                    $data[$i]['name'] = $user->name;
                    $data[$i]['email'] = $user->email;
                    $data[$i]['id'] = $user->id;
                    $propertyTenant = PropertyTenant::where('user_id', $user->id)->first();
                    if(count($propertyTenant)>0){
                        $data[$i]['start_date'] = substr($propertyTenant->start_date,0,10);
                    }else{
                        $data[$i]['start_date'] = '';
                    }
                    $i++;
                }

            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function postNewUserWizard(Request $request){
        $selectType = $request->get('select-type');
        $user = Auth::user();
        $existUser = $request->get('existUser');
        $invitationID = $request->get('invitationID');
        $unitNameList = [
            'A','B','C','D','E','F','G','H','I'
        ];
        if($user->hasRole('Guest')){
            RoleUser::where('user_id', $user->id)->where('role_id', 6)->delete();
        }
        if($selectType == 'landlord'){
            if(!$user->hasRole('landlord')) {
                $roleUser = new RoleUser();
                $roleUser->role_id = 2;
                $roleUser->user_id = $user->id;
                $roleUser->save();
            }
//            $promo = Promo::whereRaw(true)->first();
//            if(count($promo)>0) {
//                $userPromo = new UserPromo();
//                $userPromo->user_id = $user->id;
//                $userPromo->promo_id = $promo->id;
//                $userPromo->start_date = Carbon::today()->toDateString();
//                $userPromo->save();
//            }
            $zipCodeList = $request->get('zipCode');
            $addressList = $request->get('address');
            $tenantRentList = $request->get('tenantRentList');
            $tenantEmails = $request->get('emailTenant');
            $tenantNames = $request->get('nameTenant');
            $existTenantEmails = $request->get('exitTenantEmail');
            $startDates = $request->get('startDate');
            $streetList = $request->get('street');
            $cityList = $request->get('city');
            $countryList = $request->get('country');
            $streetNoList = $request->get('streetNo');
            $stateList = $request->get('state');
            $latList = $request->get('lat');
            $lngList = $request->get('lng');
            if(count($addressList)>0) {
                if($invitationID){
                    $landlordInvitationTenant = LandlordInvitation::findOrFail($invitationID);
                    $existPropertyTenant = PropertyTenant::where('user_id', $landlordInvitationTenant->tenant_id)->first();
                }
                foreach ($addressList as $key =>$address){
                    if($invitationID) {
                        if(count($existPropertyTenant) >0 ){
                            $property = Property::where('id', $existPropertyTenant->property_id)->where('address', $address)->first();
                            if(count($property) >0){
                                foreach ($existTenantEmails as $existKey => $existTenantEmail) {
                                    if ($existTenantEmail == $tenantEmails[$key]) {
                                        $existPropertyTenant->start_date = date("Y-m-d H:i:s", strtotime($startDates[$existKey]));
                                        $existPropertyTenant->save();
                                    }
                                }
                                continue;
                            }
                        }
                    }
                    if($tenantRentList[$key] == 'Whole Apartment'){
                        $existProperty = Property::where('street_no', $streetNoList[$key])->where('street', $streetList[$key])->where('post_code', $zipCodeList[$key])
                            ->where('state', $stateList[$key])->whereNull('parent_id')->first();
                        if(count($existProperty) >0){
                            $property = $existProperty;
                        }else {
                            $property = $this->saveProperty($countryList[$key],$addressList[$key], $streetList[$key], $streetNoList[$key], $cityList[$key], $zipCodeList[$key], $stateList[$key], $latList[$key], $lngList[$key]);
                        }

                    }else if($tenantRentList[$key] == 'Only a room'){
                        $existProperty = Property::where('street_no', $streetNoList[$key])->where('street', $streetList[$key])->where('post_code', $zipCodeList[$key])
                                         ->where('state', $stateList[$key])->whereNull('parent_id')->first();
                        if(count($existProperty) >0){
                            $propertiesCount = Property::where('parent_id', $existProperty->id)->count();
                            $property = $this->saveProperty($countryList[$key],$addressList[$key], $streetList[$key], $streetNoList[$key], $cityList[$key], $zipCodeList[$key], $stateList[$key], $latList[$key], $lngList[$key], $existProperty->id, $unitNameList[$propertiesCount]);
                        }else{
                            $propertyParent = $this->saveProperty($countryList[$key],$addressList[$key], $streetList[$key], $streetNoList[$key], $cityList[$key], $zipCodeList[$key], $stateList[$key], $latList[$key], $lngList[$key]);
                            $property = $this->saveProperty($countryList[$key],$addressList[$key], $streetList[$key], $streetNoList[$key], $cityList[$key], $zipCodeList[$key], $stateList[$key], $latList[$key], $lngList[$key], $propertyParent->id, 'A');
                        }
                    }
                    if($tenantRentList[$key] == 'Whole Apartment' || $tenantRentList[$key] == 'Only a room' ) {
                        $tenantInvitation = new TenantInvitation();
                        $tenantInvitation->tenant_email = $tenantEmails[$key];
                        $tenantInvitation->tenant_name = $tenantNames[$key];
                        $tenantInvitation->property_id = $property->id;
                        $tenantInvitation->landlord_id = $user->id;
                        $tenantInvitation->save();
                        $tenantUser = User::where('email', $tenantEmails[$key])->first();
                        if (count($tenantUser) == 0) {
                            $lastTenantInvitation = TenantInvitation::where('landlord_id', $user->id)->where('tenant_email', $tenantEmails[$key])->first();
                            $url = route('register', ['tenant', $lastTenantInvitation->id]);
                            Mail::to($tenantEmails[$key])->send(new mailTenantInvitation($url, $user, $tenantNames[$key], $property));
                        } else {
                            foreach ($existTenantEmails as $existKey => $existTenantEmail) {
                                if ($existTenantEmail == $tenantEmails[$key]) {
                                    $propertyTenant = new PropertyTenant();
                                    $propertyTenant->property_id = $property->id;;
                                    $propertyTenant->user_id = $tenantUser->id;
                                    $propertyTenant->collection_day = 1;
                                    $propertyTenant->start_date = date("Y-m-d H:i:s", strtotime($startDates[$existKey]));
                                    $propertyTenant->end_date = NULL;
                                    $propertyTenant->state = '';
                                    $propertyTenant->save();
                                }
                            }


                        }
                    }
                }
            }

        }  else if($selectType = 'tenant'){
            if(!$user->hasRole('Tenant')) {
                $roleUser = new RoleUser();
                $roleUser->role_id = 4;
                $roleUser->user_id = $user->id;
                $roleUser->save();
            }
            $tenant_address_street = $request->get('tenant-address-street');
            $tenant_address_street_no = $request->get('tenant-address-street-no');
            $tenant_address_state = $request->get('tenant-address-state');
            $tenant_address_zipCode = $request->get('tenant-address-zipcode');
            $tenant_address_city = $request->get('tenant-address-city');
            $tenant_address_country = $request->get('tenant-address-country');
            $tenant_address_lat = $request->get('tenant-address-lat');
            $tenant_address_lng = $request->get('tenant-address-lng');
            $tenant_address = $request->get('tenant-address');
            $tenant_start_date = $request->get('tenant-start-date');
            $rent_type = $request->get('rent-type');
            if($rent_type == 'apartment'){
                $existProperty = Property::where('street_no', $tenant_address_street_no)->where('street', $tenant_address_street)->where('post_code', $tenant_address_zipCode)
                    ->where('state', $tenant_address_state)->whereNull('parent_id')->first();
                if(count($existProperty) >0){
                    $property = $existProperty;
                }else {
                    $property = $this->saveProperty($tenant_address_country,$tenant_address, $tenant_address_street, $tenant_address_street_no, $tenant_address_city, $tenant_address_zipCode, $tenant_address_state, $tenant_address_lat, $tenant_address_lng);
                }
            }else if($rent_type =='room'){
                $existProperty = Property::where('street_no', $tenant_address_street_no)->where('street', $tenant_address_street)->where('post_code', $tenant_address_zipCode)
                    ->where('state', $tenant_address_state)->whereNull('parent_id')->first();
                if(count($existProperty) >0){
                    $propertiesCount = Property::where('parent_id', $existProperty->id)->count();
                    $property = $this->saveProperty($tenant_address_country,$tenant_address, $tenant_address_street, $tenant_address_street_no, $tenant_address_city, $tenant_address_zipCode, $tenant_address_state, $tenant_address_lat, $tenant_address_lng, $existProperty->id, $unitNameList[$propertiesCount]);
                }else{
                    $propertyParent = $this->saveProperty($tenant_address_country,$tenant_address, $tenant_address_street, $tenant_address_street_no, $tenant_address_city, $tenant_address_zipCode, $tenant_address_state, $tenant_address_lat, $tenant_address_lng);
                    $property = $this->saveProperty($tenant_address_country,$tenant_address, $tenant_address_street, $tenant_address_street_no, $tenant_address_city, $tenant_address_zipCode, $tenant_address_state, $tenant_address_lat, $tenant_address_lng, $propertyParent->id, 'A');
                }
            }
            $propertyTenant = new PropertyTenant();
            $propertyTenant->property_id = $property->id;;
            $propertyTenant->user_id = $user->id;
            $propertyTenant->collection_day = 1;
            $propertyTenant->start_date =date("Y-m-d H:i:s", strtotime($tenant_start_date));
            $propertyTenant->end_date = NULL;
            $propertyTenant->state = '';
            $propertyTenant->save();

            $landlord_email = $request->get('landlord-email');
            $landlordInvitation = new LandlordInvitation();
            $landlordInvitation->tenant_id = $user->id;
            $landlordInvitation->landlord_email = $landlord_email;
            $landlordInvitation->landlord_name = $request->get('landlord-name');
            $landlordInvitation->save();
            $landlordUser = User::where('email', $landlord_email)->first();
            $landlordName = $request->get('landlord-name');
            if(count($landlordUser) == 0 ){
                $lastLandlordInvitation = LandlordInvitation::where('tenant_id', $user->id)->where('landlord_email', $landlord_email)->first();
                $url = route('register', ['landlord', $lastLandlordInvitation->id]);
                Mail::to($landlord_email)->send(new mailLandlordInvitation($url, $user, $landlordName, $property));
            }
        }
        echo "success";
        exit;
    }

    public function saveProperty($countryKey, $address , $street, $street_no, $city, $zipCode, $state, $lat, $lng, $parentPropertyID =null, $unitID=null){
        $country = Country::where('title', $countryKey)->where('status', '1')->first();
        if(count($country) >0) {
            $countryID = $country->id;
        }else {
            $countryID = 1;
        }
        $property = new Property();
        $title = '';
        $slug = '';
        if(!is_null($street)){
            $title .= $street. ' ';
        }
        if(!is_null($street_no)){
            $title .= $street_no.' ';
            $slug .= $street_no;
        }
        if(!is_null($zipCode)){
            $title .= $zipCode .' ';
            $slug .= '-'.$zipCode;
        }
        if(!is_null($city)){
            $title .= ' ('. $city .' )';
            $slug .= '-'.$city;
        }
        if($parentPropertyID !=null && $unitID != ""){
            $property->parent_id = $parentPropertyID;
            $property->title = "Kamer ".$unitID;
            $property->property_type_id = 1;
        }else{
            $property->title = $title ;
            $property->property_type_id = 2;
        }
        $property->plan = 'free';
        $property->is_pro = 0;
        $property->is_autoshare = 0;
        $property->country_id = $countryID;
        $property->street_no = $street_no;
        $property->street = $street;
        $property->city = $city;
        $property->state = $state;
        $property->post_code = $zipCode;
        $property->lng = $lng;
        $property->lat = $lat;
        $property->status = 1;
        $property->user_id = Auth::user()->id;
        $property->description = '';
        $property->address = $address;
        $property->save();

        return $property;
    }
}