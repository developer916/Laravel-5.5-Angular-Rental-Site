<?php

namespace App\Http\Controllers\Auth;

use App\Libraries\MenuManager;
use App\Mail\DeleteAccountConfirm;
use App\Mail\UserPasswordChange;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Profile;
use App\Models\RoleUser;
use Mail;
use Redirect;
use Auth;
Use Illuminate\Http\Request;
use App\DepositRelay;
use DB;
use App\Libraries\TenantManager;
use App\Models\Property;
use App\Models\PropertyTenant;
use App\Models\Country;
use Carbon\Carbon as Carbon;
use SoapClient;
use App\Models\UserInfo;
use App\Mail\registerTenantToLandlord;
use App\Mail\registerLandlordToTenant;
use App\Mail\registerLandlordToLandlord;
use App\Mail\registerTenantToTenant;
use App\Mail\emptyLandlordIBAN;
use App\Models\Role;
use App\Models\LandlordInvitation;
use App\Models\TenantInvitation;
use App\Models\UserPromo;
use App\Models\Promo;
use App\Http\Requests\Auth\RegisterRequest;
use App\Events\UserPasswordWasReset;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    const RESET_PASS_SUCCESS   = 1;
    const RESET_PASS_NOT_FOUND = 2;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $lang = 'en';
        $arrAllowedLanguages = ['en', 'nl'];

        $geoLocation = \GeoIP::getLocation();
        if (isset($geoLocation)) {
            if (isset($geoLocation['iso_code'])) {
                if (in_array(strtolower($geoLocation['iso_code']), $arrAllowedLanguages)) {
                    $lang = strtolower($geoLocation['iso_code']);
                }
            }
        } elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (in_array($browserLang, $arrAllowedLanguages)) {
                $lang = $browserLang;
            }
        }
        \Session::put('locale', $lang);
        \App::setLocale($lang);
//        setcookie('lang', $lang, 0, '/');

        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function showRegistrationForm($userType= null, $id=null){
        $email  = '';
        $name = '';
        if($userType == 'landlord'){
            $landlordInvitation = LandlordInvitation::findOrFail($id);
            $email = $landlordInvitation->landlord_email;
            $name = $landlordInvitation->landlord_name;
        }else if($userType == 'tenant'){
            $tenantInvitation = TenantInvitation::findOrFail($id);
            $email = $tenantInvitation->tenant_email;
            $name = $tenantInvitation->tenant_name;
        }
        return view('auth.register', ['email' => $email, 'name' =>$name, 'selectType' =>$userType, 'id' =>$id]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' =>$this->quickRandom(32),
        ]);
        return $user;
    }

    public function register(Request $request)
    {
        $selectType = $request->get('selectType');
        $invitationID = $request->get('invitationID');
        $email = $request->get('email');
        $user = User::where('email', $email)->first();
        if(count($user)>0) {
            $user->password = bcrypt($request->get('password'));
            $user->save();
            $message = "Your  password has been updated. Please use last password for our system login.";
        }else{
            $parent_id = 0;
            if($selectType == 'landlord'){
                $landlordInvitation =LandlordInvitation::findOrFail($invitationID);
                if(($landlordInvitation->landlord_email != $email) || ($landlordInvitation->landlord_email != $request->get('name')) ){
                    $landlordInvitation->landlord_email = $email;
                    $landlordInvitation->landlord_name = $request->get('name');
                    $landlordInvitation->save();
                }
                $landlordRole =DB::table('roles')->where('slug','landlord')->first();
                if(count($landlordRole)>0 ) {
                    $accType                 = $landlordRole->id;
                }else {
                    return Redirect::to('/auth/register')->with('message', "Landlord Role doesn't exit");
                }
            }else if($selectType == 'tenant'){
                $tenantInvitation = TenantInvitation::findOrFail($invitationID);
                if(($tenantInvitation->tenant_name != $request->get('name')) || ($tenantInvitation->tenant_email != $email)){
                    $tenantInvitation->tenant_name = $request->get('name');
                    $tenantInvitation->tenant_email = $email;
                    $tenantInvitation->save();
                }
                $parent_id = $tenantInvitation->landlord_id;
                $tenantRole =DB::table('roles')->where('slug','tenant')->first();
                if(count($tenantRole)>0 ) {
                    $accType                 = $tenantRole->id;
                }else {
                    return Redirect::to('/auth/register')->with('message', "Tenant Role doesn't exit");
                }
            }else{
                $guestRole = DB::table('roles')->where('slug','guest')->first();
                if(count($guestRole)>0 ) {
                    $accType                 = $guestRole->id;
                }else {
                    return Redirect::to('/auth/register')->with('message', "Guest Role doesn't exit");
                }
            }
            $this->validator($request->all())->validate();
            event(new Registered($user = $this->create($request->all())));
            $confirmCode = $this->quickRandom(32);

            $data = $request->all();
            $user = User::where('email', $data['email'])->first();
            $message = "Your password has been saved. Please use this password for our system login." ;
            if (count($user)>0) {
                $user->parent_id  = $parent_id;
                $user->confirmed  = 0;
                $user->has_login  = 1;
                $user->admin  = 1;
                $user->confirmation_code= $confirmCode;
                if($selectType =='landlord' || $selectType =='tenant'){
                    $user->confirmed = 1;
                }
                $user->save();

                $roleUser = new RoleUser();
                $roleUser->role_id = $accType;
                $roleUser->user_id = $user->id;
                $roleUser->save();

                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->avatar = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar5.png'; // assign a default avatar
                $profile->phone = '';
                $profile->save();

                $this->guard()->logout($user);
                if($selectType != 'landlord' && $selectType !='tenant'){
                    $confirmUrl = route('confirmLandlord', [$user->confirmation_code, $user->id ]);

                    Mail::send('emails.GuestCreated', ['user' => $user, 'password' => bcrypt($data['password']), 'loginLink' => url('auth/login'), 'confirmLink' => $confirmUrl], function ($m) use (
                        $user
                    ) {
                        $m->to($user->email, $user->name)->subject(trans('register.welcome'));
                    });
                }else if($selectType == 'tenant'){
                    $tenantInvitations = TenantInvitation::where('id', $invitationID)->first();
                    $propertyTenant = new PropertyTenant();
                    $propertyTenant->property_id = $tenantInvitations->property_id;
                    $propertyTenant->user_id = $user->id;
                    $propertyTenant->collection_day = 1;
                    $currentTime = Carbon::now();
                    $propertyTenant->start_date =$currentTime->toDateTimeString();
                    $propertyTenant->save();
                }else if($selectType == 'landlord'){
                    $tenant = User::where('id', $landlordInvitation->tenant_id)->first();
                    $tenant->parent_id = $user->id;
                    $tenant->save();
//                    $promo = Promo::whereRaw(true)->first();
//                    if(count($promo)>0) {
//                        $userPromo = new UserPromo();
//                        $userPromo->user_id = $user->id;
//                        $userPromo->promo_id = $promo->id;
//                        $userPromo->start_date = Carbon::today()->toDateString();
//                        $userPromo->save();
//                    }
                }

            }
        }
        return Redirect::to('auth/login')->with('message', $message);
    }

    public function depositRegister(Request $request){
        $this->validate($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $id = $request->get('setID');
        $type= $request->get('slug');
        $email= $request->get('email');
        $password = $request->get('password');
        if($type == 'landlord'){
            $depositRelay = DepositRelay::where('id',$id)->where('landlord_email', $email)->where('status' , '0')->first();
        }else if ($type == 'tenant'){
            $depositRelay = DepositRelay::where('id',$id)->where('tenant_email', $email)->where('is_cancelled' , '0')->first();
        }
        if(count($depositRelay) >0 ){
            if($type == 'landlord') {
                $user = User::findOrFail($depositRelay->landlord_id);
            }else if($type == 'tenant') {
                $user = User::findOrFail($depositRelay->tenant_id);
            }
            $user->password = bcrypt($password);
            $user->save();
            $message = 'Your password has been updated. Please use this email and password for our system.';
            return Redirect::to('auth/login')->with('message', $message);

        }else {
            return redirect()->back()->with('status', 'Email is not exist!!');
        }

    }

    public function ibanCheck(Request $request) {
        header('Access-Control-Allow-Origin: *');
        $iban = $request->get('iban');
        $user = "Rentling";
        $password = "7Ne-dtH-Uy5-2qL";
        $client = new SoapClient('https://ssl.ibanrechner.de/soap?wsdl');
        $result = $client->validate_iban($iban, $user, $password);
        $return = $result->result == 'passed' ? $result->bank : '';
        echo $return;
        exit;
    }

    public function postTenantDepositRelay(Request $request){
        header('Access-Control-Allow-Origin: *');
        $iban = $request->get('landlord-iban');
        if($iban == '') {
            $bank = '';
            $landlord_email = $request->get('landlord-email');
            Mail::to($landlord_email)->send(new emptyLandlordIBAN());

        }else {
            $user = "Rentling";
            $password = "7Ne-dtH-Uy5-2qL";
            $client = new SoapClient('https://ssl.ibanrechner.de/soap?wsdl');
            $result = $client->validate_iban($iban, $user, $password);
            $bank = $result->result == 'passed' ? $result->bank : '';
        }
        $date = $request->get('move_in_date');

        $depositRelay = new DepositRelay();
        $depositRelay->house_number = $request->get('street_number') ? $request->get('street_number') : '' ;
        $depositRelay->street = $request->get('route') ? $request->get('route') : '';
        $depositRelay->city = $request->get('locality') ? $request->get('locality') : '';
        $depositRelay->state = $request->get('state') ? $request->get('state') : '';
        $depositRelay->postal_code = $request->get('postal_code') ? $request->get('postal_code') : '';
        $depositRelay->country = $request->get('country') ? $request->get('country') : '';
        $depositRelay->move_in_date = date("Y-m-d H:i:s", strtotime($date) );
        $depositRelay->landlord_name = $request->get('landlord-fname') .' '. $request->get('landlord-lname');
        $depositRelay->landlord_email = $request->get('landlord-email');
        $landlord_mobile  = '';
        if($request->has('landlord-country-code')) {
            $landlord_mobile .= $request->get('landlord-country-code');
        }
        if($request->has('landlord-area-code')) {
            $landlord_mobile .= $request->get('landlord-area-code');
        }
        if($request->has('landlord-phone-number')) {
            $landlord_mobile .= $request->get('landlord-phone-number');
        }
        $depositRelay->landlord_mobile = $landlord_mobile;
        $depositRelay->bank_name = $bank;
        $depositRelay->rent = $request->get('deposit-amount');
        $depositRelay->tenant_first_name = $request->get('your-fname');
        $depositRelay->tenant_last_name = $request->get('your-lname');
        $tenant_mobile = '';
        if($request->has('your-area-code')) {
            $tenant_mobile .=$request->get('your-area-code');
        }
        if($request->has('your-phone-number')) {
            $tenant_mobile .=$request->get('your-phone-number');
        }
        $depositRelay->tenant_mobile = $tenant_mobile;
        $depositRelay->tenant_email = $request->get('your-email');
        $depositRelay->currency = '';
        $depositRelay->status = \Config::get('deposit-relay.status.RELAY_STATUS_SUBMITTED');
        $depositRelay->save();
        $tenant_email = $request->get('your-email');
        $depositRelayResult = DepositRelay::where('tenant_email', $tenant_email)->first();
        $this->UpdateUserAndDeposit($depositRelayResult->id, 'tenant', $tenant_email);
        echo "success";
        exit;
    }

    public function postLandlordDepositRelay(Request $request) {
        header('Access-Control-Allow-Origin: *');
        $iban = $request->get('your-iban');
        $user = "Rentling";
        $password = "7Ne-dtH-Uy5-2qL";
        $client = new SoapClient('https://ssl.ibanrechner.de/soap?wsdl');
        $result = $client->validate_iban($iban, $user, $password);
        $bank = $result->result == 'passed' ? $result->bank : '';

        $date = $request->get('move_in_date');

        $depositRelay = new DepositRelay();
        $depositRelay->house_number = $request->get('street_number') ? $request->get('street_number') : '' ;
        $depositRelay->street = $request->get('route') ? $request->get('route') : '';
        $depositRelay->city = $request->get('locality') ? $request->get('locality') : '';
        $depositRelay->state = $request->get('state') ? $request->get('state') : '';
        $depositRelay->postal_code = $request->get('postal_code') ? $request->get('postal_code') : '';
        $depositRelay->country = $request->get('country') ? $request->get('country') : '';
        $depositRelay->move_in_date = date("Y-m-d H:i:s", strtotime($date) );

        $depositRelay->tenant_first_name = $request->get('tenant-fname');
        $depositRelay->tenant_last_name = $request->get('tenant-lname');
        $tenant_mobile = '';
        if($request->has('tenant-country-code')) {
            $tenant_mobile .= $request->get('tenant-country-code');
        }
        if($request->has('tenant-area-code')) {
            $tenant_mobile .= $request->get('tenant-area-code');
        }
        if($request->has('tenant-phone-number')) {
            $tenant_mobile .= $request->get('tenant-phone-number');
        }
        $depositRelay->tenant_mobile = $tenant_mobile;
        $depositRelay->tenant_email = $request->get('tenant-email');

        $depositRelay->landlord_name = $request->get('your-fname') .' '. $request->get('your-lname');
        $depositRelay->landlord_email = $request->get('your-email');
        $depositRelay->currency = '';
        $depositRelay->status =\Config::get('deposit-relay.status.RELAY_STATUS_SUBMITTED');
        $depositRelay->bank_name = $bank;
        $depositRelay->rent = $request->get('deposit-amount');
        $landlord_mobile = '';
        if($request->has('your-area-code')) {
            $landlord_mobile .=$request->get('your-area-code');
        }
        if($request->has('your-phone-number')) {
            $landlord_mobile .=$request->get('your-phone-number');
        }
        $depositRelay->landlord_mobile = $landlord_mobile;

        $depositRelay->save();
        $landlord_email = $request->get('your-email');
        $depositRelayResult = DepositRelay::where('landlord_email', $landlord_email)->first();
        $this->UpdateUserAndDeposit($depositRelayResult->id, 'landlord', $landlord_email);
        echo "success";
        exit;
    }

    public function UpdateUserAndDeposit($id, $type, $email){
        $depositRelayRoles = DB::table('roles')->where('slug', 'depositrelay')->get();
        $depositRelayRole = 1;
        if(count($depositRelayRoles) >0){
            $depositRelayRole = $depositRelayRoles[0]->id;
        }
        $url = url('auth/login');
        if($type == 'landlord'){
            $depositRelay = DepositRelay::where('id',$id)->where('landlord_email', $email)->first();
        }else if ($type == 'tenant'){
            $depositRelay = DepositRelay::where('id',$id)->where('tenant_email', $email)->first();
        }
        $tenantExist = 0;
        $landlordExist = 0;
        if(count($depositRelay) >0 ){
            if($type == 'landlord'){
                $landlordUser = User::where('email', $email)->first();
                $clientEmail = $depositRelay->tenant_email;
                $tenantUser  = User::where('email', $clientEmail)->first();
                if(count($landlordUser)>0) {
                    $landlordExist = 1;
                    if(count($tenantUser) > 0) {
                        $tenantExist = 1;
                        $this->setPropertyAndPropertyTenant($landlordUser, $tenantUser, $depositRelay);
                    } else {
                        $tenantUser = $this->saveUser($depositRelay, $type);
                        $this->setPropertyAndPropertyTenant($landlordUser, $tenantUser, $depositRelay);
                    }
                    $tenantUser  = User::where('email', $clientEmail)->first();
                    $tenantUser->parent_id = $landlordUser->id;
                    $tenantUser->save();

                }else{
                    $this->saveUser($depositRelay, 'tenant');
                    $landlordUser = User::where('email', $email)->first();
                    if(count($tenantUser) > 0) {
                        $this->setPropertyAndPropertyTenant($landlordUser, $tenantUser, $depositRelay);
                    } else {
                        $tenantUser = $this->saveUser($depositRelay, $type);
                        $this->setPropertyAndPropertyTenant($landlordUser, $tenantUser, $depositRelay);
                        $tenantUser  = User::where('email', $clientEmail)->first();
                        $tenantUser->parent_id = $landlordUser->id;
                        $tenantUser->save();
                    }
                }
                if(!$landlordUser->hasRole('DepositRelay')){
                    $roleUser = new RoleUser();
                    $roleUser->role_id = $depositRelayRole;
                    $roleUser->user_id = $landlordUser->id;
                    $roleUser->save();
                }
                if(!$landlordUser->hasRole('Landlord')){
                    $roleUser = new RoleUser();
                    $roleUser->role_id = 2;
                    $roleUser->user_id = $landlordUser->id;
                    $roleUser->save();
                }

                if(!$tenantUser->hasRole('DepositRelay')){
                    $roleUser = new RoleUser();
                    $roleUser->role_id = $depositRelayRole;
                    $roleUser->user_id = $tenantUser->id;
                    $roleUser->save();
                }
                if(!$tenantUser->hasRole('Tenant')){
                    $roleUser = new RoleUser();
                    $roleUser->role_id = 4;
                    $roleUser->user_id = $tenantUser->id;
                    $roleUser->save();
                }
                $depositRelay->tenant_id = $tenantUser->id ;
                $depositRelay->landlord_id = $landlordUser->id;
                $depositRelay->save();

            }else if($type == 'tenant') {
                $tenantUser = User::where('email', $email)->first();
                $clientEmail = $depositRelay->landlord_email;
                $landlordUser = User::where('email', $clientEmail)->first();
                if (count($tenantUser) > 0) {
                    $tenantExist = 1;
                    if (count($landlordUser) > 0) {
                        $landlordExist = 1;
                        $this->setPropertyAndPropertyTenant($landlordUser, $tenantUser, $depositRelay);
                        $tenantUser = User::where('email', $email)->first();
                        $tenantUser->parent_id = $landlordUser->id;
                        $tenantUser->save();
                    } else {
                        $tenantUser = $this->saveUser($depositRelay, $type);
                        $this->setPropertyAndPropertyTenant($landlordUser, $tenantUser, $depositRelay);
                    }
                } else {
                    $this->saveUser($depositRelay, 'landlord');
                    $tenantUser = User::where('email', $email)->first();
                    if (count($landlordUser) > 0) {
                        $this->setPropertyAndPropertyTenant($landlordUser, $tenantUser, $depositRelay);
                    } else {
                        $landlordUser = $this->saveUser($depositRelay, $type);
                        $this->setPropertyAndPropertyTenant($landlordUser, $tenantUser, $depositRelay);
                        $tenantUser = User::where('email', $email)->first();
                        $tenantUser->parent_id = $landlordUser->id;
                        $tenantUser->save();
                    }
                }

                if(!$landlordUser->hasRole('DepositRelay')){
                    $roleUser = new RoleUser();
                    $roleUser->role_id = $depositRelayRole;
                    $roleUser->user_id = $landlordUser->id;
                    $roleUser->save();
                }
                if(!$landlordUser->hasRole('Landlord')){
                    $roleUser = new RoleUser();
                    $roleUser->role_id = 2;
                    $roleUser->user_id = $landlordUser->id;
                    $roleUser->save();
                }

                if(!$tenantUser->hasRole('DepositRelay')) {
                    $roleUser = new RoleUser();
                    $roleUser->role_id = $depositRelayRole;
                    $roleUser->user_id = $tenantUser->id;
                    $roleUser->save();
                }

                if(!$tenantUser->hasRole('Tenant')){
                    $roleUser = new RoleUser();
                    $roleUser->role_id = 4;
                    $roleUser->user_id = $tenantUser->id;
                    $roleUser->save();
                }
                $depositRelay->tenant_id = $tenantUser->id ;
                $depositRelay->landlord_id = $landlordUser->id;
                $depositRelay->save();
            }

            $tenant_email = $depositRelay->tenant_email;
            $landlord_email = $depositRelay->landlord_email;
            $tenantUrl = route('confirmDeposit', [$id, 'tenant']);
            $landlordUrl = route('confirmDeposit', [$id, 'landlord']);

            if($type == 'landlord'){
                Mail::to($tenant_email)->send(new registerLandlordToTenant($url, $depositRelay, $tenantExist, $tenantUrl));
                Mail::to($landlord_email)->send(new registerLandlordToLandlord($url, $depositRelay, $landlordExist, $landlordUrl));
            } else if($type == 'tenant'){
                Mail::to($tenant_email)->send(new registerTenantToTenant($url, $depositRelay, $tenantExist, $tenantUrl));
                Mail::to($landlord_email)->send(new registerTenantToLandlord($url, $depositRelay, $landlordExist, $landlordUrl));
            }
            return;
        } else {
            return redirect()->back()->with('status', 'Email is not exist!!');
        }
    }


    public function setPropertyAndPropertyTenant($landlordUser,$tenantUser, $depositRelay ) {
        $countryID = 1;
        $property_id = 0;
        $countries = Country::where('title', $depositRelay->country)->first();
        if(count($countries) >0){
            $countryID = $countries->id;
        }
        $property = Property::where('country_id', $countryID)->where('street_no', $depositRelay->house_number)->where('street', $depositRelay->street)->where('post_code', $depositRelay->postal_code)->get();
        if(count($property) == 0){
            $property = new property();
            $title = '';
            $slug = '';
            $address ='';
            if(!is_null($depositRelay->street)){
                $title .= $depositRelay->street. ' ';
                $address .= $depositRelay->street. ' ';
            }
            if(!is_null($depositRelay->house_number)){
                $title .= $depositRelay->house_number .' ';
                $slug .= $depositRelay->house_number;
                $address .= $depositRelay->house_number. ' ';
            }
            if(!is_null($depositRelay->postal_code)){
                $title .= $depositRelay->postal_code .' ';
                $slug .= '-'.$depositRelay->postal_code;
                $address .= $depositRelay->postal_code. ' ';
            }
            if(!is_null($depositRelay->city)){
                $title .= ' ('. $depositRelay->city .' )';
                $slug .= '-'.$depositRelay->city;
                $address .= $depositRelay->city. ' ';
            }
            $property->title = $title ;
            $property->property_type_id = 2;
            $property->plan = 'free';
            $property->is_pro = 0;
            $property->is_autoshare = 0;
            $property->country_id = $countryID;
            $property->slug = $slug;
            $property->address = $address;
            $property->street_no = $depositRelay->house_number;
            $property->street = $depositRelay->street;
            $property->city = $depositRelay->city;
            $property->state = $depositRelay->state;
            $property->post_code = $depositRelay->postal_code;
            $property->lng = 0;
            $property->lat = 0;
            $property->status = 1;
            $property->user_id = $landlordUser->id;
            $property->description = '';
            $property->save();
        }
        $property = Property::where('country_id', $countryID)->where('street_no', $depositRelay->house_number)->where('street', $depositRelay->street)->where('post_code', $depositRelay->postal_code)->get();
        if(count($property) >0){
            $property_id = $property[0]->id;
        }
        $propertyTenant = PropertyTenant::where('property_id', $property_id)->first();
        if(count($propertyTenant)  == 0) {
            $propertyTenant = new PropertyTenant();
            $propertyTenant->property_id = $property_id;
            $propertyTenant->user_id = $tenantUser->id;
            $propertyTenant->collection_day = 1 ;
            $propertyTenant->start_date = $depositRelay->move_in_date;
            $propertyTenant->end_date = NULL;
            $propertyTenant->state = '';
            $propertyTenant->save();
        }else {
            $propertyTenant ->user_id = $tenantUser->id;
            $propertyTenant->start_date = $depositRelay->move_in_date;
            $propertyTenant->end_date = NULL;
            $propertyTenant->save();
        }

        return;
    }
    public function saveUser($depositRelay, $type, $password = null){
        if(!$password){
            $password =$this->quickRandom(8);
        }
        if($type == 'landlord'){
            $name              = $depositRelay->tenant_first_name. ' '. $depositRelay->tenant_last_name;
            $email             = $depositRelay->tenant_email;
            $accType           = 4;
            $phone             = $depositRelay->tenant_mobile;
        }else if($type =='tenant'){
            $name              = $depositRelay->landlord_name;
            $email             = $depositRelay->landlord_email;
            $accType           = 2;
            $phone             = $depositRelay->landlord_mobile;
        }
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = bcrypt($password);
            $user->confirmation_code = $this->quickRandom(32);
            $user->confirmed = 1;
            $user->parent_id = 0;
            $user->admin = 1;
            $user->save();
            $user = User::where('email', $email)->first();

            $roleUser = new RoleUser();
            $roleUser->role_id = $accType;
            $roleUser->user_id = $user->id;
            $roleUser->save();

            $profile = new Profile();
            $profile->phone =$phone;
            $profile->user_id = $user->id;
            $profile->avatar = 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/avatars/avatar5.png'; // assign a default avatar
            $profile->save();

            $userInfo = new UserInfo();
            $userInfo->phone = $phone;
            $userInfo->state = 0;
            $userInfo->receive_visit_offers = 1;
            $userInfo->save();

            $this->guard()->logout($user);

        return $user;
    }
    public function testTenantManager(){
        $menuManager = new MenuManager(314);
        print_r($menuManager->GetAllRoleBasedMenu());
    }
    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function deleteAccountConfirm($id){
        $user = User::where('id', $id)->first();
        $name = $user->name;
        $email = $user->email;
        $dateTime = date('Y-m-d H:i:s');
        User::where('id', $id)->delete();
        Mail::to($email)->send(new DeleteAccountConfirm($name, $dateTime));
        echo "Your account has been deleted.";
        exit;
    }

    public function postForgotPassword (RegisterRequest $request) {
        $email = $request->all()['data']['email'];

        $user = User::where('email', $email)->first();
        if ($user) {
            $newStringPassword = substr(md5(mt_rand()), 0, 10);
            $newPassword       = bcrypt($newStringPassword);
            $user->password    = $newPassword;
            if ($user->save()) {
                $user->password  = $newStringPassword;
                $user->loginLink = url('auth/login');
                Mail::to($email)->send(new  UserPasswordChange($user));
                return response()->json(['status' => self::RESET_PASS_SUCCESS]);
            }
        } else {
            return response()->json(['status' => self::RESET_PASS_NOT_FOUND, 'msg' => trans('register.email_notfound')]);
        }
    }
}
