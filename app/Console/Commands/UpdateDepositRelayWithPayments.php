<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Property;
use App\Models\PropertyTenant;
use App\Models\DepositRelay;
use App\Mail\depositRelayToPaymentLandlord;
use App\Mail\depositRelayToPaymentTenant;
use App\Models\Payment;
use Mail;
class UpdateDepositRelayWithPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateDepositRelayWithPayments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updated deposit relay with payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $depositRelays = DepositRelay::where('move_in_date', '<', date('Y-m-d') . " 00:00:00")->where('status', \Config::get('deposit-relay.status.RELAY_STATUS_CAPTURED_FROM_TENANT'))->get();
        if(count($depositRelays)>0) {
            foreach ($depositRelays as $depositRelay){
                $payment = Payment::where('landlord_id', $depositRelay->landlord_id)->where('tenant_id', $depositRelay->tenant_id)->where('amount', $depositRelay->rent)->first();
                if(count($payment) >0) {
                    $depositRelay->status = \Config::get('deposit-relay.status.RELAY_STATUS_SUBMITTED_FOR_RELEASE_TO_LANDLORD');
                    $depositRelay->save();
                    $property = Property::where('street_no', $depositRelay->house_number)->where('street', $depositRelay->street)->where('post_code', $depositRelay->postal_code)->first();
                    $propertyTenant = PropertyTenant::where('user_id', $depositRelay->tenant_id)->where('property_id' , $property->id)->first();
                    Mail::to($depositRelay->tenant_email)->send(new depositRelayToPaymentTenant($depositRelay, $property,$propertyTenant));
                    Mail::to($depositRelay->landlord_email)->send(new depositRelayToPaymentLandlord($depositRelay, $property,$propertyTenant));
                    $depositRelayRoles = \DB::table('roles')->where('slug', 'depositrelay')->first();
                    if(count($depositRelayRoles) >0){
                        $depositRelayRole = $depositRelayRoles->id;
                        RoleUser::where('user_id', $depositRelay->tenant_id)->where('role_id', $depositRelayRole)->delete();
                        RoleUser::where('user_id', $depositRelay->landlord_id)->where('role_id', $depositRelayRole)->delete();
                    }
                }

            }
        }
        $this->info('Deposit Relay updated successfully');
    }
}
