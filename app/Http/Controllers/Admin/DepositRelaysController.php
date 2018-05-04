<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Mail\depositRelayTenantLandlord;
use App\Mail\depositRelayCancelLandlord;
use App\Mail\depositRelayCancelTenant;
use App\Mail\depositRelayToPaymentLandlord;
use App\Mail\depositRelayToPaymentTenant;
use App\Models\Profile;
use App\Models\PropertyFinancial;
use App\Models\PropertyTenant;
use App\Models\RoleUser;
use Auth;

use App\User;
use App\Models\Property;
use App\DepositRelay;
use Illuminate\Http\Request;
use Mail;

class DepositRelaysController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $returnData =  $this->getAllRelays();
        if(!empty($returnData['depositRelays'])){
            $depositRelays = $returnData['depositRelays'];
            $role = $returnData['role'];
            foreach ($depositRelays as $key => $depositRelay){
                $depositRelay->address = $depositRelay->house_number. ', '. $depositRelay->street. ', ' . $depositRelay->city. ', '. $depositRelay->postal_code. ', '. $depositRelay->country;
                if($role == 'DepositRelayLandlord') {
                    $depositRelay->landlord = '';
                    $depositRelay->tenant = $depositRelay->tenant_first_name. ' '. $depositRelay->tenant_last_name;
                    if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_TENANT') || $depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_LANDLORD')){
                        $depositRelay ->actions = '';
                    }else{
                        $depositRelay ->actions = '<a onclick="return confirm(\'' . trans('actions.cancel_deposit_landlord') . '\')"  class="btn-delete btn btn-xs btn-circle red  hidden-md hidden-sm hidden-xs"><i class="fa fa-pencil"></i><span class="hidden-480">' . trans('actions.cancel') . '</span></a>';
                    }

                }else if($role == 'DepositRelayTenant'){
                    $depositRelay->landlord = $depositRelay->landlord_name;
                    $depositRelay->tenant = '';
                    if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_TENANT') || $depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_LANDLORD')){
                        $depositRelay ->actions = '';
                    }else {
                        $depositRelay ->actions = '<a onclick="onCancelDepositRelay(' . $depositRelay->id . ' , \'' . trans('actions.cancel_deposit_tenant') . '\')"  class="btn-delete btn btn-xs btn-circle red  hidden-md hidden-sm hidden-xs"><i class="fa fa-pencil"></i><span class="hidden-480">' . trans('actions.cancel') . '</span></a>';
                    }

                }
                $type = 'change_date';
                if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_TENANT') || $depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_LANDLORD')){
                    $depositRelay->move_in_date=  substr($depositRelay->move_in_date,0,10);
                }else{
                    $depositRelay->move_in_date ='<a onclick="onChangeEditAmount(' . $depositRelay->id . ' , \''.$type.'\')"  href="javascript:;">'.substr($depositRelay->move_in_date,0,10).'</a>';
                }

                $currency_symbol = '';
                if($depositRelay->currency == 'eur'){
                    $currency_symbol = '&euro;';
                }else if($depositRelay->currency == 'gbp'){
                    $currency_symbol = '&pound;';
                }else {
                    $currency_symbol ='$';
                }
                $type = 'change_amount';
                if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_TENANT') || $depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_LANDLORD')){
                    $depositRelay->deposit_amount = $currency_symbol.$depositRelay->rent;
                }else {
                    $depositRelay->deposit_amount = '<a onclick="onChangeEditAmount(' . $depositRelay->id . ' , \''.$type.'\')"  href="javascript:;">'.$currency_symbol.$depositRelay->rent.'</a>';
                }

                if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_SUBMITTED')) {
                    $depositRelay->status = 'Submitted';
                }else if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CAPTURED_FROM_TENANT')) {
                    $depositRelay->status = 'Captured';
                }else if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_SUBMITTED_FOR_RELEASE_TO_LANDLORD')) {
                    $depositRelay->status = 'Release to landlord';
                }else if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_RELEASED_TO_LANDLORD')) {
                    $depositRelay->status = 'Released';
                }else if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_TENANT')) {
                    $depositRelay->status = 'Cancelled by Tenant';
                }else if($depositRelay->status == \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_LANDLORD')) {
                    $depositRelay->status = 'Cancelled by Landlord';
                }
            }
            return response()->json([
                'data' => $depositRelays,
                'recordsFiltered' => count($depositRelays),
                'draw' => 2,
                'recordsTotal' => count($depositRelays)
            ]);
        }
    }

    public function getAllRelays(){
        $user = Auth::user();
        unset($user->password);
        unset($user->confirmation_code);
        unset($user->remember_token);
        $depositTenant = 0;
        $depositLandlord = 0;

        $roles = is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
        if (in_array('depositrelay', $roles)  && in_array('landlord', $roles)) {
            $depositLandlord = 1;
        }
        if (in_array('depositrelay', $roles)  && in_array('tenant', $roles)) {
            $depositTenant = 1;
        }

        if($depositLandlord == 1) {
            $depositRelays = DepositRelay::where('landlord_email', $user->email)->get();
//            $depositRelays = DepositRelay::where('landlord_email', $user->email)->where('status' , \Config::get('deposit-relay.status.RELAY_STATUS_SUBMITTED'))->get();
            $role = 'DepositRelayLandlord';

        }else if($depositTenant == 1){
            $depositRelays = DepositRelay::where('tenant_email', $user->email)->get();
            $role = 'DepositRelayTenant';
        }
        $returnData = [
            'depositRelays' =>$depositRelays,
            'role' => $role,
            'user' => $user
        ];
        return $returnData;
    }
    public function getRelays(){
       $returnData = $this->getAllRelays();

        if (!empty($returnData['depositRelays'])) {
            return response()->json($returnData);
        }
        return response()->json(['status' => 0]);
    }

    public function getChangeableData(Request $request){
        $id = $request->get('id');
        $type = $request->get('type');
        $depositRelay = DepositRelay::findOrFail($id);
        if($type == 'change_amount') {
            $amount = $depositRelay->rent;
            $data = [
                'id' => $id,
                'type' => $type,
                'result' => $amount
            ];
        }else if($type== 'change_date') {
            $date = substr($depositRelay->move_in_date,0,10);
            $data = [
                'id' => $id,
                'type' => $type,
                'result' => $date
            ];
        }
        return response()->json($data);
    }
    public function saveDepositRelay (Request $request){
        $id = $request->get('id');
        $depositRelay = DepositRelay::findOrFail($id);
       if($request->get('type') == 'change_amount') {
           $amount = $request->get('amount');
            $depositRelay->rent = $amount;
            $depositRelay->save();
       } else if ($request->get('type') == 'change_date') {
           $depositRelay->move_in_date = $request->get('move_in_date');
           $depositRelay->save();
       }

        $tenant_email = $depositRelay->tenant_email;
        $landlord_email = $depositRelay->landlord_email;

        $user = Auth::user();
        $depositTenant = 0;
        $depositLandlord = 0;

        $roles = is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
        if (in_array('depositrelay', $roles)  && in_array('landlord', $roles)) {
            $depositLandlord = 1;
        }
        if (in_array('depositrelay', $roles)  && in_array('tenant', $roles)) {
            $depositTenant = 1;
        }

        $message_landlord = '';
        $message_tenant = '';

        if ($depositLandlord == 1){
            if($request->get('type') == 'change_amount') {
                $message_tenant = 'Hi '.$depositRelay->tenant_first_name.' '. $depositRelay->tenant_last_name . ', Landlord has been changed the amount.' ;
                $message_landlord ='Hi '. $depositRelay->landlord_name.', if you changed amount, the tenant has to agree.';
            }else if($request->get('type') == 'change_date'){
                $message_tenant = 'Hi '.$depositRelay->tenant_first_name.' '. $depositRelay->tenant_last_name . ', Landlord has been changed the date.' ;
                $message_landlord ='Hi '. $depositRelay->landlord_name.', if you changed date, the tenant has to agree.';
            }

        }else if ($depositTenant == 1) {
            if($request->get('type') == 'change_amount') {
                $message_tenant = 'Hi '.$depositRelay->tenant_first_name.' '. $depositRelay->tenant_last_name . ', if you changed amount, the landlord has to agree.';
                $message_landlord ='Hi '. $depositRelay->landlord_name.', Landlord has been changed the amount.' ;
            }else if($request->get('type') == 'change_date'){
                $message_tenant = 'Hi '.$depositRelay->tenant_first_name.' '. $depositRelay->tenant_last_name . ', if you changed date, the landlord has to agree.';
                $message_landlord ='Hi '. $depositRelay->landlord_name.', Landlord has been changed the date.' ;
            }
        }
        $depositRelay->message = $message_tenant;
        Mail::to($tenant_email)->send(new depositRelayTenantLandlord($depositRelay));
        $depositRelay->message = $message_landlord;
        Mail::to($landlord_email)->send(new depositRelayTenantLandlord($depositRelay));

       return response()->json(['status' => 0]);
    }

    public function setCancelDepositRelay(Request $request){
        $id = $request->get('id');
        $cancel_reason = $request->get('cancel_reason');
        $depositRelay = DepositRelay::findOrFail($id);
        $user = Auth::user();
        $roles = is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
        if (in_array('depositrelay', $roles)  && in_array('landlord', $roles)) {
            $status = \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_LANDLORD');
            $type = 'landlord';
        }
        if (in_array('depositrelay', $roles)  && in_array('tenant', $roles)) {
            $status = \Config::get('deposit-relay.status.RELAY_STATUS_CANCEL_BY_TENANT');
            $type = 'tenant';
        }
        $depositRelay->status = $status;
        $depositRelay->cancel_reason = $cancel_reason;
        $depositRelay->save();
        $property = Property::where('street_no', $depositRelay->house_number)->where('street', $depositRelay->street)->where('post_code', $depositRelay->postal_code)->first();
        if(count($property) >0){
            $propertyTenant = PropertyTenant::where('property_id', $property->id)->where('user_id', $depositRelay->tenant_id)->first();
            $propertyTenant->end_date = $propertyTenant->start_date;
            $propertyTenant->save();
        }

        Mail::to($depositRelay->tenant_email)->send(new depositRelayCancelTenant($depositRelay, $type, $property));
        Mail::to($depositRelay->landlord_email)->send(new depositRelayCancelLandlord($depositRelay, $type, $property));


        $depositRelayRoles = \DB::table('roles')->where('slug', 'depositrelay')->first();
        if(count($depositRelayRoles) >0){
            $depositRelayRole = $depositRelayRoles->id;
            RoleUser::where('user_id', $depositRelay->tenant_id)->where('role_id', $depositRelayRole)->delete();
            RoleUser::where('user_id', $depositRelay->landlord_id)->where('role_id', $depositRelayRole)->delete();
        }
        return response()->json(['status' => 0 ]);
    }

}