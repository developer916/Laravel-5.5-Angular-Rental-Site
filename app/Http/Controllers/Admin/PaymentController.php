<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

//use App\Language;
use App\Models\Payment;
use App\Models\Invoice;

use App\Http\Requests\AdyenRequest;

class PaymentController extends AdminController {


    public function getPayment ($id) {
    }

    public function getPayments () {

        if (Auth::user()->role->first()->slug == 'landlord') {
            $payments = Payment::where('landlord_id', Auth::user()->id)->get(['id', 'status','amount', 'payment_status', 'created_at', 'invoice_id', 'payment_method']);
            $count    = Payment::where('landlord_id', Auth::user()->id)->count();
        } elseif (Auth::user()->role->first()->slug == 'tenant') {
            $payments = Payment::where('tenant_id', Auth::user()->id)->get(['id', 'status','amount', 'payment_status', 'created_at', 'invoice_id', 'payment_method']);
            $count    = Payment::where('tenant_id', Auth::user()->id)->count();
        }

        if (isset($payments)) {
            foreach ($payments as $payment) {

                $payment->actions = '
                    <a href="#/invoice/view/' . $payment->id . '" class="btn default btn-xs green-stripe">View</a>
                    <a href="/invoice/' . $payment->id . '" class="btn default btn-xs green-stripe">Pay</a>
                    <a href="/invoice/delete/' . $payment->id . '" class="btn default btn-xs green-stripe">Delete</a>
';
                $payment->property = 0;
                $payment->tenant = 0;
            }

            return response()->json(['data' => $payments, 'recordsFiltered' => $count, 'draw' => 0, 'recordsTotal' => $count]);
        } else {
            return response()->json(['data' => [], 'draw' => 0, 'recordsTotal' => 0]);
        }
    }

    /**
     * Receive ADYEN payment post requests
     *
     *
     */

    public function postHandlePayment (AdyenRequest $request) {
        Log::info('Payment request received:', $request->all());
        echo '[accepted]';
    }

    /**
     * Payment ADYEN redirect
     *
     * all payment parameters are in _GET
     *
     */

    public function getPaymentResult () {
        $getData = $_GET;

        //        Array
        //        (
        //            [authResult] => REFUSED
        //    [merchantReference] => RentomatoPayment @1 - 05/10/2015 23:08
        //    [merchantSig] => Hguu5MQygkx1G7YrtTxJPu5Fal5dF5XHfNriXWx6KXI=
        //            [paymentMethod] => mc
        //    [pspReference] => 8614440865351704
        //    [shopperLocale] => en_GB
        //    [skinCode] => X37I3kWG
        //)

        preg_match('/RentomatoPayment @(\d+)/', $getData['merchantReference'], $matches);
        $invoiceId = $matches[1];

        $invoice = Invoice::find($invoiceId);

        $payment                 = new Payment();
        $payment->invoice_id     = $invoiceId;
        $payment->landlord_id    = $invoice->landlord_id;
        $payment->tenant_id      = $invoice->tenant_id;
        $payment->payment_method = $getData['paymentMethod'];
        $payment->payment_status = $getData['authResult'];
        $payment->psp_reference  = $getData['pspReference'];
        $payment->save();
    }

}
