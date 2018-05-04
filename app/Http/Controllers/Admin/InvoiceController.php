<?php namespace App\Http\Controllers\Admin;

use App\Events\InvoiceWasGenerated;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

//use App\Language;
use App\Models\Invoice;

use Carbon\Carbon;

use App\User;
use App\Models\Property;
use App\Models\PropertyFinancial;
use App\Models\Tenant;
use App\Models\PropertyTenant;
use App\Models\PropertyMonthlyExpense;

class InvoiceController extends AdminController {


	const APP_INVOICE_STATUS_NEW            = 1;
	const APP_INVOICE_STATUS_PAID           = 2;
	const APP_INVOICE_STATUS_PARTIALLY_PAID = 3;
	const APP_INVOICE_STATUS_LATE           = 4;
	const APP_INVOICE_STATUS_CANCELLED      = 5;

	public function getInvoice ($id) {
		$invoice = Invoice::find($id);

		$invoiceItems = [];

		$invoice->landlord = User::find($invoice->landlord_id);
		$invoice->tenant   = User::find($invoice->tenant_id);
		$invoice->property = Property::find($invoice->property_id);
		$financials        = PropertyFinancial::where('property_id', $invoice->property_id)->get();
		$monthlyExpenses   = PropertyMonthlyExpense::where('property_id', $invoice->property_id)->get();
		$rent              = 0;
		foreach ($financials as $finance) {
			if (isset($finance->deposit)) {
				$invoiceItems[] = [
					'item'  => trans('invoice.deposit'),
					'cost'  => $finance->deposit,
					'tax'   => 0,
					'total' => $finance->deposit
				];
			}
			if (isset($finance->commission)) {
				$invoiceItems[] = [
					'item'  => trans('invoice.commission'),
					'cost'  => $finance->commission,
					'tax'   => 0,
					'total' => $finance->commission
				];
			}
			if (isset($finance->rent)) {

				if (isset($finance->rent_tax)) {
					$rent = round(($finance->rent + (($finance->rent * $finance->rent_tax) / 100)), 2);
				}
				$invoiceItems[] = [
					'item'  => trans('invoice.rent'),
					'cost'  => $finance->rent,
					'tax'   => $finance->rent_tax,
					'total' => $rent
				];
			}
		}

		foreach ($monthlyExpenses as $expense) {

			$total = $expense->amount;
			if (isset($expense->tax) && $expense->tax != 0) {
				$total = round($expense->amount + (($expense->amount * 100) / $expense->tax), 2);
			}

			$invoiceItems[] = [
				'item'  => trans($expense->type),
				'cost'  => $expense->amount,
				'tax'   => $expense->tax,
				'total' => $total
			];
		}

		$invoice->items = $invoiceItems;

		/** @Generate Adyen URL */

		$skinCode        = env('APP_ADYEN_SKIN');
		$merchantAccount = env('APP_ADYEN_MERCHANT_ACCOUNT');
		$hmacKey         = env('APP_ADYEN_TEST_HMAC_KEY');

		/*
		 payment-specific details
		 */

		$params = [
			"merchantReference" => "RentomatoPayment @$id - " . date('d/m/Y H:i'),
			"merchantAccount"   => $merchantAccount,
			"currencyCode"      => "EUR",
			"paymentAmount"     => $rent * 100,
			//            "sessionValidity"   => "2015-12-25T10:31:06Z",
			"sessionValidity"   => gmdate('Y-m-d\TH:i:s\Z', strtotime('+2 days')),
			"shipBeforeDate"    => date("Y-m-d", strtotime("+10 days")),
			"shopperLocale"     => "en_GB",
			"skinCode"          => $skinCode
		];

		// The character escape function
		$escapeval = function ($val) {
			return str_replace(':', '\\:', str_replace('\\', '\\\\', $val));
		};

		// Sort the array by key using SORT_STRING order
		ksort($params, SORT_STRING);

		// Generate the signing data string
		$signData = implode(":", array_map($escapeval, array_merge(array_keys($params), array_values($params))));

		// base64-encode the binary result of the HMAC computation
		$merchantSig           = base64_encode(hash_hmac('sha256', $signData, pack("H*", $hmacKey), TRUE));
		$params["merchantSig"] = $merchantSig;

		$link = env('APP_ADYEN_PAY_URL');
		foreach ($params as $key => $value) {
			$link .= htmlspecialchars($key, ENT_COMPAT | ENT_HTML401, 'UTF-8') . '=' . htmlspecialchars($value, ENT_COMPAT | ENT_HTML401, 'UTF-8') . '&';
		}

		$invoice->payLink = rtrim($link, '&');

		return response()->json($invoice);
	}

	public function getInvoices () {

		$invoices = [];
		$return   = [];
		if (Auth::user()->role->first()->slug == 'landlord') {
			$invoices = Invoice::where('landlord_id', Auth::user()->id)->get(['id', 'property_id', 'tenant_id', 'status', 'amount', 'discount', 'currency', 'due_at', 'created_at']);
			$count    = Invoice::where('landlord_id', Auth::user()->id)->count();
		} elseif (Auth::user()->role->first()->slug == 'tenant') {
			$invoices = Invoice::where('tenant_id', Auth::user()->id)->get(['id', 'property_id', 'tenant_id', 'status', 'amount', 'discount', 'currency', 'due_at', 'created_at']);
			$count    = Invoice::where('tenant_id', Auth::user()->id)->count();
		}
		if ($invoices) {
			foreach ($invoices as $invoice) {
				if (isset($invoice->property_id)) {
					$property = Property::find($invoice->property_id);
					if (isset($property->title)) {
						$invoice->property = Property::find($invoice->property_id)->title;
						$invoice->amount   = $invoice->amount . '&euro;';
						$invoice->fine     = 0;
						$invoice->tenant   = Tenant::find($invoice->tenant_id)->name;
						$invoice->due_at   = date('d.m.Y', strtotime($invoice->due_at));
						$invoice->status   = invoiceStatus($invoice->status);
						$invoice->actions  = invoiceActions($invoice->id);
						$return[]          = $invoice;
					}
				}
			}

			return response()->json(['data' => $return, 'recordsFiltered' => $count, 'draw' => 0, 'recordsTotal' => $count]);
		} else {
			return response()->json(['data' => [], 'recordsFiltered' => 0, 'draw' => 0, 'recordsTotal' => 0]);
		}
	}

	public function deleteInvoice ($id) {
		$invoice = Invoice::where('id', $id)->first();
		if ($invoice) {
			$remove = $invoice->delete();
			if ($remove) {
				return response()->json(['status' => 1]);
			}
		}

		return response()->json(['status' => 0]);
	}


	public function getGenerateInvoices () {

		$activeTenants = PropertyTenant::where('start_date', '<', Carbon::now())->get();
		foreach ($activeTenants as $activeTenant) {

			$property          = Property::find($activeTenant->property_id);
			$tenant            = Tenant::find($activeTenant->user_id);
			$propertyFinancial = PropertyFinancial::where('property_id', $activeTenant->property_id)->first();

			$invoice              = new Invoice();
			$invoice->user_id     = Auth::user()->id;
			$invoice->landlord_id = $property->user_id;
			$invoice->tenant_id   = $tenant->id;
			$invoice->amount      = 1250;
			$invoice->discount    = 0;
			$invoice->currency    = 1;
			$invoice->notes       = '';
			$invoice->description = '';
			$invoice->due_at      = Carbon::now()->addMonth();
			$invoice->property_id = $property->id;

			if ($invoice->save()) {
				\Event::fire(new InvoiceWasGenerated($invoice, 'assign-tenant-email'));
			}
		}
	}

}
