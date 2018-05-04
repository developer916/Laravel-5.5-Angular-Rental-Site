<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//use App\Language;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\PropertyTenant;
use DB;
use App\User;
use App\Models\Property;
use App\Models\UserInfo;
use App\Http\Requests\AdyenRequest;
use phpDocumentor\Reflection\Types\Null_;
use App\Models\PaymentImport;
use App\Libraries\TenantManager;
use File;
class PaymentPerTenantController extends AdminController {

    public function getRoleMethod($user){
        return is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
    }

    private $tenantsWithTokenizedNames;
    function __construct() {
        parent::__construct();
        $this->tenantsWithTokenizedNames = null;
    }
    public function getTenantLists() {
        $roles = $this->getRoleMethod(Auth::getUser());
        $landlordRoleFlag = 0;
        $adminRoleFlag = 0;
        $managerRoleFlag = 0;
        $tenantRoleFlag = 0;
        $tenantRole = 0;
        $lastImportDate = '';
        if (in_array('landlord', $roles)) {
            $landlordRoleFlag = 1;
            $tenantRole = 0;
        }
        if (in_array('administrator', $roles)) {
            $adminRoleFlag = 1;
            $tenantRole = 0;
        }
        if (in_array('manager', $roles)) {
            $managerRoleFlag = 1;
            $tenantRole = 0;
        }
        if (in_array('tenant', $roles)) {
            $tenantRoleFlag = 1;
            $tenantRole = 1;
        }

        if($adminRoleFlag == 1 || $managerRoleFlag == 1) {
            $sql = 'SELECT users.id, users.name,property_tenants.end_date, properties.street_no , properties.unit as roomID
                    FROM `property_tenants` 
                    INNER JOIN users on property_tenants.user_id = users.id 
                    INNER JOIN properties on properties.id = property_tenants.property_id 
                    ORDER by property_tenants.end_date DESC';
            $paymentImport = PaymentImport::orderBy('timestamp','DESC')->first();
        }
        if($landlordRoleFlag == 1) {
            $sql = 'SELECT users.id, users.name,property_tenants.end_date, properties.street_no,    properties.unit as roomID
                    FROM `property_tenants` 
                    INNER JOIN users on property_tenants.user_id = users.id 
                    INNER JOIN properties on properties.id = property_tenants.property_id 
                    where users.parent_id = '.Auth::user()->id.'
                    ORDER by property_tenants.end_date DESC';
            $paymentImport = PaymentImport::where('user_id' , Auth::user()->id)->orderBy('timestamp','DESC')->first();
        }
        if($tenantRoleFlag == 1) {
            $sql = 'SELECT users.id, users.name,property_tenants.end_date, properties.street_no , properties.unit as roomID
                    FROM `property_tenants` 
                    INNER JOIN users on property_tenants.user_id = users.id 
                    INNER JOIN properties on properties.id = property_tenants.property_id 
                    where property_tenants.user_id = '.Auth::user()->id.'
                    ORDER by property_tenants.end_date DESC';
            $lastImportDate = '';
        }
        if($adminRoleFlag == 1 || $managerRoleFlag == 1 || $landlordRoleFlag == 1) {
            if(count($paymentImport) >0 ) {
                $lastImportDate = $paymentImport->timestamp;
            }else {
                $lastImportDate = '';
            }
        }
        $propertyTenants = DB::select($sql);
        if(count($propertyTenants) >0) {
            $resultPayment = $this->getPaymentList($propertyTenants[0]->id);
        }else {
            $resultPayment = [];
        }
        $tenants = array();
        $tenantsWithTokenizedNames = array();
        for ($i = 0; $i< sizeof($propertyTenants); $i++){
            $result = '';
            $result = $propertyTenants[$i]->id . ' | '. $propertyTenants[$i]->street_no;
            if(!is_null($propertyTenants[$i]->end_date)) {
                $result .= ' | ' . substr($propertyTenants[$i]->end_date,0,10);
            }
            $result .= ' | '. $propertyTenants[$i]->name;
            $tenantsWithTokenizedNames[$propertyTenants[$i]->id] = preg_split('/\s+/', $propertyTenants[$i]->name);
            $tenants[] = array('id' => $propertyTenants[$i]->id, 'name' => $result);
        }
        return $data =[
            'tenants' => $tenants,
            'lastImportDate' =>$lastImportDate,
            'resultPayment' => $resultPayment,
            'tenantRole' => $tenantRole,
            'tenantsWithTokenizedNames' =>$tenantsWithTokenizedNames
        ];
    }
    public function getTenants () {
        return response()->json($this->getTenantLists());
    }
    public function getTenantPayment($id){
        $resultPayment = $this->getPaymentList($id);
        $data = [
            'resultPayment' =>$resultPayment
        ];
        return response()->json($data);
    }

    public function getPaymentList($tenantID){
        $paymentsDue = array();
        $totalDue = 0;
        $earlyTerminationFee = 0;
        $charges = 0;
        $credits = 0;
        $contractEndDate = null;
        $payments = array();
        $chargesCredits = array();
        $totalRentPayments = 0;
        $depositReturn = 0;
        $isDeregistered = false;
        $deregistrationProofUrl = null;

        $tenant = new TenantManager($tenantID);
        $dp = $tenant->GetPaymentsDue();

        foreach ($dp as $p) {
            $paymentsDue[] = array(
                'date' => is_null($p['startDate']) ? '' : $p['startDate']->format('j-M-Y'),
                'description' => $p['description'],
                'amount' => number_format((float) $p['amount'], 2)
            );
            $totalDue += (float) $p['amount'];
        }
        $tf = $tenant->GetEarlyCancellationFee();
        $earlyTerminationFee = number_format($tf['terminationFee'], 2);
        $charges = $tenant->GetCurrentCharges();
        $credits = $tenant->GetCurrentCredits();
        $contractEndDate = $tenant->GetContractEndDate();
        $allPayments = $tenant->GetPayments();
        $i=1;

        foreach ($allPayments as $p) {
            $payment = array(
                'id' => $p['id'],
                'amount' => number_format((float) $p['amount'], 2),
                'comments' => $p['psp_reference'],
                'date' => date('d-M-Y', strtotime($p['created_at'])),
                'index' => $i++
            );
            $payments[] = $payment;

            $totalRentPayments += (float) $p['amount'];
        }

        $allChargesCredits = $tenant->GetChargesAndCredits(null, null);

        foreach ($allChargesCredits as $c) {
            $item = array(
                'amount' => number_format((float) $c['amount'], 2),
                'comments' => $c['comments'],
                'date' => date('m-d-Y', strtotime($c['date']))
            );
            $chargesCredits[] = $item;
        }
        $depositReturn = $totalRentPayments - $totalDue - ((float) $charges) + ((float) $credits) - ((float) $tf['terminationFee']) + ((float) $tenant->GetPossibleEarlyCancellationFees()['deposit']);
        $totalRentDifference = number_format($totalDue - $totalRentPayments, 2);
        $isDeregistered = $tenant->IsDeRegistered();


        return $returnData = [
            'paymentsDue' => $paymentsDue,
            'totalDue' => number_format($totalDue, 2),
            'totalRentDifference' =>$totalRentDifference,
            'earlyTerminationFee' =>$earlyTerminationFee,
            'charges' => number_format($charges, 2),
            'credits' =>number_format($credits, 2),
            'contractEndDate' =>is_null($contractEndDate) ? '' : date('d-M-Y', strtotime($contractEndDate)),
            'payments' => $payments,
            'totalRentPayments' => number_format($totalRentPayments,2),
            'chargesCredits' => $chargesCredits,
            'depositReturn' => number_format($depositReturn,2),
            'isDeregistered' => $isDeregistered,
            'deregistrationProofUrl' => $tenant->GetDeregistrationProofUrl()
        ];
    }

    public function importFileUpload(Request $request){
        $lineCount = 0;
        $amountRentThreshold = 200;
        $successAddedLine = 0;
        $errorRowIds = array();
        if($request->hasFile('uploadedFile')){
            if(!file_exists(public_path('/uploads/csv'))){
                File::makeDirectory(public_path('/uploads/csv'), 0775, true, true);
            }
            $file = $request->file('uploadedFile');
            $extension = $file->getClientOriginalExtension();
            if($extension == 'csv') {
                $file_name = time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/csv');
                $file->move($destinationPath, $file_name);
                if (($handle = fopen(public_path('/uploads/csv/'.$file_name), 'r')) !== FALSE)
                {
                    while (($row = fgetcsv($handle)) !== FALSE)
                    {
                        if ($lineCount > 0){
                            $i = 0;
                            while ($i < count($row)) {
                                $row[$i] = trim(preg_replace('/[\n\r\"]/', '', $row[$i]));
                                if (strlen($row[$i]) == 0)
                                    array_splice($row, $i, 1);
                                else
                                    $i++;
                            }
                            $lines[] = $row;
                        }
                        $lineCount++;
                    }
                    fclose($handle);
                    $lineCount = 0;
                    $returnData = $this->getTenantLists();
//                    $paymentHashes = Payment::whereNotNull('hash')->get();
                    $tenantsWithTokenizedNames = $returnData['tenantsWithTokenizedNames'];
                    foreach ($lines as $lineKey => $values) {
                        $dt = date_create_from_format('Ymd', $values[0]);
                        $date = $dt->format('Y-m-d');
                        $amount = floatval(preg_replace('/[\,]/', '.', $values[6]));
                        if (strcasecmp($values[5], "af") === 0)
                            $amount = -$amount;
                        $remarkTokens = array_merge(preg_split('/\s+/', $values[1]), preg_split('/\s+/', $values[8]));
                        $remarks = $values[8];
                        $paymentTenantId = null;
                        foreach ($tenantsWithTokenizedNames as $tenantId => $nameTokens) {
                            if (count($nameTokens) >= 2 && (strlen($nameTokens[count($nameTokens) -1]) > 0)) {
                                foreach ($remarkTokens as $t) {
                                    if (strcasecmp($t, $nameTokens[count($nameTokens) -1]) === 0) {
                                        $paymentTenantId = $tenantId;
                                        break;
                                    }
                                }
                            }
                            if (!is_null($paymentTenantId)) break;
                        }
                        $rentMonth = null;
                        $rentYear = null;
                        if (!is_null($paymentTenantId)){
                            $payment = new Payment();
                            $payment->landlord_id = Auth::user()->id ;
                            $payment->tenant_id =is_null($paymentTenantId) ? 'NULL' : $paymentTenantId;
                            $payment->amount = $amount;
                            $payment->status = '';
                            $payment->payment_status = '';
                            //comment and date didn't add
                            $payment->payment_method = $values['7'];
                            $payment->psp_reference = $remarks;
                            $payment->created_at = $date;
                            $payment->save();
                            $successAddedLine++;
                            if($amount >= $amountRentThreshold) {
                                $paymentDay = intval($dt->format('d'));
                                $paymentMonth = intval($dt->format('m'));
                                $paymentYear = intval($dt->format('Y'));
                                $dtPrevMonth = date_create($date . ' first day of last month');
                                $paymentPrevMonth = intval($dtPrevMonth->format('m'));
                                $paymentPrevYear = intval($dtPrevMonth->format('Y'));
                                $dtNextMonth = date_create($date . ' first day of +1 month');
                                $paymentNextMonth = intval($dtNextMonth->format('m'));
                                $paymentNextYear = intval($dtNextMonth->format('Y'));
                                $isEarlyPayment = false;
                                $isLatePayment = false;
                                if ($paymentDay <= 15) {	// Payment was made on 1st half of the month, so interpret it as a payment for the previous month
                                    $rentMonth = $paymentPrevMonth;
                                    $rentYear = $paymentPrevYear;
                                    $isLatePayment = $paymentDay > 3;
                                }else {	// Payment was made on 2nd half of the month, so interpret it as a payment for the current month
                                    $rentMonth = $paymentMonth;
                                    $rentYear = $paymentYear;
                                    $isEarlyPayment = $paymentDay < intval($dt->format('t'));
                                }

                                if ($isEarlyPayment) {
                                    $tenant = new TenantManager($paymentTenantId);
                                    $tenant->CreateEarlyRentPaymentCredit($rentMonth, $rentYear);
                                }else if ($isLatePayment) {
                                    $tenant = new TenantManager($paymentTenantId);
                                    $tenant->CreateLateRentPaymentCharge($rentMonth, $rentYear);
                                }
                            }
                        }
                        if (is_null($paymentTenantId))
                            $errorRowIds[] = $lineKey+ 2;

                        $lineCount++;
                    }
                }
                if (count($errorRowIds) > 0){
                    $errorMessages = implode(', ' , $errorRowIds). " rows didn't save in the csv file . Our system didn't find this tenant";
                }else {
                    $errorMessages = '';
                }
                if($lineCount > 0) {
                    $successMessages = $successAddedLine." rows saved successfully";
                }else {
                    $successMessages = 'Empty rows Added';
                }
                $paymentImport = new PaymentImport();
                $paymentImport->user_id = Auth::user()->id;
                $paymentImport->timestamp = date('Y-m-d H:i:s');
                $paymentImport->save();
                $data = [
                    'type' =>'success',
                    'error_messages' => $errorMessages,
                    'success_messages' => $successMessages
                ];

            }else{
                $data = [
                    'type' =>'error',
                    'message' => 'Invalid File'
                ];
            }
            return response()->json($data);
        }
    }
    public function deregFileUpload(Request $request){
        if($request->hasFile('deregFile')){
            $file = $request->file('deregFile');
            $tenantID= 240;
            $tenant = new TenantManager($tenantID);
            $extension = $file->getClientOriginalExtension();
            if (($extension!= "jpg") && ($extension != "jpeg") && ($extension != "gif") && ($extension != "png") && ($extension != "bmp")){
                $data = [
                    'type' =>'error',
                    'message' => 'Invalid File.'
                ];
            }else{
                $file_name = $tenantID.'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/deregistrations');
                $file->move($destinationPath, $file_name);
                $tenant->DeRegister($file);
                $data = [
                    'type' =>'success',
                    'message' => 'Uploaded successfully.'
                ];
            }
            return response()->json($data);
        }
    }
}