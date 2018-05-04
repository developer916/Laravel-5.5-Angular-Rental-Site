<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Redirect;
use Mail;
use App\DepositRelay;
use Lang;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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

        $this->middleware('guest')->except('logout');
    }

    protected  function authenticated(Request $request, $user){
        if($user->confirmed == 0 ){
            Auth::logout();
            return back()->with('message', 'Please confirm you account with the e-mail we sent. Also check your spam box.');
        }
        $roles  = is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
        if (in_array('guest', $roles)) {
            return redirect('/guest');
        }else{
            if($user->last_login){
                return redirect()->intended($this->redirectPath());
            }else{
                if (in_array('tenant', $roles)) {
                    return redirect('/dashboard');
                }else {
                    return redirect('/guest');
                }
            }

        }

    }
    public function landlordConfirm(Request $request, $slug , $id){
        $user= User::where('id', $id)->where('confirmation_code', $slug)->first();
        $user->confirmed = 1;
        $user->save();
        return Redirect::to('auth/login')->with('success', 'Congratulation!  Your email has been verified.');

    }

    public function sendConfirm(Request $request, $id, $type){
        $deposit_relay = DepositRelay::where('id', $id)->first();
        if(count($deposit_relay) >0){
            $email = "";
            $name = "";
            $url = route('confirmDeposit', [$id, $type]);
            if($type == "landlord"){
                $email = $deposit_relay->landlord_email;
                $name = $deposit_relay->landlord_name;
            }else if($type == "tenant"){
                $email = $deposit_relay->tenant_email;
                $name = $deposit_relay->tenant_first_name. " " . $deposit_relay->tenant_last_name;
            }
            Mail::send('emails.sendConfirm', ['email' => $email, 'url' =>$url, 'name' => $name], function ($m) use($email) {

                $m->to($email)->subject(trans('register.send_confirm'));
            });

            echo Lang::get('register.congratulation_confirm');
            exit;
        }else{
            return back();
        }
    }

    public function deposit(Request $request, $id , $type){
        $deposit_relay = DepositRelay::findOrFail($id);
        $set_password = 0;
        if($type == "landlord"){
            $user = User::where('email', $deposit_relay->landlord_email)->first();
            if(count($user)>0){
                $roles = $user->role();
            }

        }else if($type == "tenant"){
            $user = User::where('email', $deposit_relay->tenant_email)->first();
            if(count($user)>0){

            }
        }
        return view('pages.set_password')->with('set_password', $set_password)->with('id', $id)->with('type', $type);
    }

    public function confirmPassword(Request $request){
        if($request->has('current_password')) {
            $this->validate($request, [
                'email' => 'required|string|email|max:255',
                'current_password' => 'required|string|min:6',
                'password' => 'required|string|min:6|confirmed',
            ]);
        }else{
            $this->validate($request, [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);
        }

        $id = $request->get('setID');
        $type= $request->get('slug');
        $email= $request->get('email');
        if($type == 'landlord'){
            $depositRelay = DepositRelay::where('id',$id)->where('landlord_email', $email)->first();
        }else if ($type == 'tenant'){
            $depositRelay = DepositRelay::where('id',$id)->where('tenant_email', $email)->first();
        }
        if(count($depositRelay) >0){
//            if($request->get('set_password')){
//                $current_password = $request->get('current_password');
//
//                if($type == 'landlord'){
//                    if(!(\Hash::check($current_password , $depositRelay->landlord_password))){
//                        return redirect()->back()->with('password_wrong', 'Current password is not correct.');
//                    }else {
//                        $depositRelay->landlord_password = bcrypt($request->get('password'));
//                    }
//                }else if($type == 'tenant'){
//                    if(!(\Hash::check($current_password , $depositRelay->tenant_password))){
//                        return redirect()->back()->with('password_wrong', 'Current password is not correct.');
//                    }else {
//                        $depositRelay->landlord_password = bcrypt($request->get('password'));
//                    }
//                }
//            }else{
//                if($type == 'landlord'){
//                    $depositRelay->landlord_password = bcrypt($request->get('password'));
//                }else if($type == 'tenant'){
//                    $depositRelay->landlord_password = bcrypt($request->get('password'));
//                }
//            }
//            $depositRelay->save();

            return Redirect::to('auth/login')->with('set_password', 'Your password has been set perfectly.');
        }else{
            return redirect()->back()->with('status', 'Email is not exist!!');
        }
    }
}
