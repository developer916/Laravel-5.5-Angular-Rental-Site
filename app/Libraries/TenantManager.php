<?php

namespace App\Libraries;

use App\Models\GeneralCharge;
use App\Models\Payment;
use App\Models\PropertyTenant;
use App\Models\RoomCleaning;
use App\User;
use App\Models\DataProperty;
use App\Models\DataPropertyName;
use App\Models\DepositCharge;
use App\Models\PropertyCharge;
use App\Models\Rent;
use App\Models\UserInfo;
use App\Models\UserPropertyConstant;
use App\Models\UtilityMeter;
use App\Models\Property;
use DB;
use File;

class TenantManager {

    const USER_STATE_CONTRACT_SENT  = 1;
    const USER_STATE_ROOM_AVAILABLE = 2;
    const USER_STATE_DEREGISTERED   = 4;


    const roomCleaningChargeDataProperty =6;
    const hostVisitCreditDataProperty = 7;
    const earlyRentPaymentCreditDataProperty = 5;
    const lateRentPaymentChargeDataProperty =4;

    static $RoomNameToRoomId = array('A' => 1, 'B' => 2, 'C' => 3, 'D' => 4);
    private $tenantId;
    private $data;
    private $userInfo;
    private $mainTenantData;      // RM will hold a record from users table mainTenant is the tenant who the government selects to pay taxes.
    // All other flat must pay their part to the main tenant. The App tenants use in their mobile calculates this amount.
    private $mainTenantDataLoaded;  //RM  Indicates if data is loaded in above variable.
    private $taxData;              //RM  Will hold user_property_constants:name="Tenanttaxes".value for current tenant
    private $taxDataLoaded;
    private $staticChargesData;      //RM  Will hold table property_charges for certain landlord (as defined by the tenant in the class)
    private $staticChargesDataLoaded;
    private $rentData;               //RM Will hold a record from the `rent` table
    private $rentDataLoaded;
    private $paymentData;            //RM Records from the `payments` table.
    private $paymentDataLoaded;

    //functions
    function __construct($tenantId) {
        $this->tenantId = $tenantId;
        $this->LoadData();
        $this->mainTenantData = null;
        $this->mainTenantDataLoaded = false;
        $this->taxData = null;
        $this->taxDataLoaded = false;
        $this->chargeTypesData = null;
        $this->chargeTypesDataLoaded = false;
        $this->staticChargesData = null;
        $this->staticChargesDataLoaded = false;
        $this->rentData = null;
        $this->rentDataLoaded = false;
        $this->paymentData = null;
        $this->paymentDataLoaded = false;
    }

    function GetTotalMonthsRented($endDate = null) {
        if (is_null($endDate)){
            $endDate = !is_null($this->data->end_date) ? strtotime($this->data->end_date) : time();  // enddate will be in $dataProperty_tenants
        }else{
            $endDate = strtotime($endDate);
        }
        return (int) ceil(($endDate - strtotime($this->data->start_date)) / (31 * 24 * 60 * 60));
    }

    function GetPossibleEarlyCancellationFees() {              // If tenants cancel their contract early, they pay a fee, depending on the period.
        global $cancel3Months, $cancel6Months, $cancel12Months;
        $rez = DepositCharge::where('user_id', $this->tenantId)->first();
        // Get cancellation fee
        if (count($rez) > 0) {
            $cancel3m = $rez->cancel3m;
            $cancel6m = $rez->cancel6m;
            $cancel1y = $rez->cancel1y;
            $deposit  = $rez->deposit;
        }
        else {
            $cancel3m = $cancel3Months;
            $cancel6m = $cancel6Months;
            $cancel1y = $cancel12Months;
            $deposit = 0;
        }

        return array(
            'cancel3m' => $cancel3m,
            'cancel6m' => $cancel6m,
            'cancel1y' => $cancel1y,
            'deposit' => $deposit
        );
    }

    function GetEarlyCancellationFee($endDate = null) {
        $fees = $this->GetPossibleEarlyCancellationFees();
        $totalMonths = $this->GetTotalMonthsRented($endDate);

        $terminationFee = 0;
        if ($totalMonths < 3)
            $terminationFee = $fees['cancel3m'];
        else if ($totalMonths < 6)
            $terminationFee = $fees['cancel6m'];
        else if ($totalMonths < 12)
            $terminationFee = $fees['cancel1y'];

        $feeDecreases = array();
        if ($totalMonths < 3)
            $feeDecreases[] = array(
                'newAmount' => $fees['cancel6m'],
                'months' => 3 - $totalMonths,
            );
        if ($totalMonths < 6)
            $feeDecreases[] = array(
                'newAmount' => $fees['cancel1y'],
                'months' => 6 - $totalMonths,
            );
        if ($totalMonths < 12)
            $feeDecreases[] = array(
                'newAmount' => 0,
                'months' => 12 - $totalMonths,
            );

        return array(
            'terminationFee' => $terminationFee,
            'feeDecreases' => $feeDecreases
        );
    }
    function GetCurrentCharges() {
        $sql = "SELECT COALESCE(sum(amount),0) as c FROM general_charges WHERE user_id=" . ($this->tenantId) . " AND amount < 0";
        $rez = DB::select($sql);
        return abs($rez[0]->c);
    }
    function GetCurrentCredits() {
        $sql = "SELECT COALESCE(sum(amount),0) as c FROM general_charges WHERE user_id=" . ($this->tenantId) . " AND amount > 0";
        $rez = DB::select($sql);
        return abs($rez[0]->c);
    }

    function GetMainTenantName() {           // main Tenant is the one who government sends the tax bill, the tenant indicates this in the mobile App.
        $this->LoadMainTenantData();
        return is_null($this->mainTenantData) ? null : $this->mainTenantData['name'];
    }

    function GetTaxAmountPerYear() {            // Tax amount maintenant has to pay. Other flat mates have to pay their part to main tenant.
        $this->LoadTaxData();                   // One day, Maybe Rentling will automatically adjust this against the deposit.
        $aptJsonFile = $this->GetApartmentJsonFilePath($this->aptNumber); // The JSON files will be maybe be moved to a new table. Unsure yet. Use dummy data for now.
        $aptData = json_decode(file_get_contents($aptJsonFile));
        $numTenants = count($aptData->rooms);    // To get nr of rooms, now need to find nr of units of a parentid in users table. Make a function GetUnits( $user_id )
        return $this->taxData / $numTenants;
    }

    function GetName() {
        return $this->data->user->name;
    }

    function GetPhoneNumber() {
        return $this->userInfo->phone;
    }

    function GetContractEndDate() {
        return $this->data->end_date;
    }
    function GetApartmentName() {
        $userPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'Woningmerk')->first();
        return (count($userPropertyConstants) == 0) ? '' : $userPropertyConstants->value;
    }
    function IsDeRegistered() {
        return (((int) $this->userInfo->state) & self::USER_STATE_DEREGISTERED) === self::USER_STATE_DEREGISTERED;
    }

    function GetDeregistrationProofUrl() {
        if (!$this->IsDeRegistered()) return null;
        $files =  glob($this->GetDeRegistrationsPath() . '/' . $this->tenantId . '.*');
        return count($files) == 0 ? null : str_replace($_SERVER['DOCUMENT_ROOT'], '', $files[0]);
    }

    function IsReceiveVisitOffersEnabled() {
        return $this->userInfo->receive_visit_offers;
    }
    public function GetHostVisitCreditAmount() {
        $credit = $this->getHostRoomVisitCredit();
        return is_null($credit) ? 0 : abs($credit['amount']);
    }

    function DeRegister($proofFile) {
//        $targetPath = $this->GetDeRegistrationsPath() . '/' . $this->tenantId . '.' . $proofFile['extension'];
//        if (!move_uploaded_file($proofFile['filePath'], $targetPath))
//            return false;

        // Update state in database
        $sql ="update users_info set state=state | " . self::USER_STATE_DEREGISTERED . " where user_id='" . $this->tenantId  . "'";
        DB::update($sql);
        $this->LoadData();
    }

    function GetStaticChargesAndCredits() {
        $this->LoadStaticChargesData();
        return $this->staticChargesData;
    }

    function GetChargesAndCredits($fromIndex, $toIndex) {
        $this->LoadStaticChargesData();

        $chargesData = array();

        $sql="SELECT * FROM general_charges WHERE user_id=" . ($this->tenantId) .
            " ORDER BY date DESC";
        if (!is_null($fromIndex) && !is_null($toIndex)){
            $sql .= " LIMIT " . ($toIndex - $fromIndex + 1). " OFFSET " . $fromIndex;
        }
        $rez = DB::select($sql);
        foreach ($rez as $r) {
            $charge = array(
                'amount' => $r->amount,
                'date' => $r->date,
                'comments' => $r->comments
            );

            if (is_null($charge['comments'])) {
                foreach ($this->staticChargesData as $staticCharge) {
                    if ($staticCharge['dataProperty'] == $r->chargetype) {
                        $charge['comments'] = $staticCharge['nameEN'];
                        break;
                    }
                }
            }

            $chargesData[] = $charge;
        }
        return $chargesData;
    }

    function IsCurrentTenantMainTenant() {
        $this->LoadMainTenantData();
        return !is_null($this->mainTenantData) && ($this->mainTenantData['id']  == $this->tenantId);
    }

    function GetTaxInfo() {
        $this->LoadMainTenantData();
        $isCurrentTenantMainTenant = $this->IsCurrentTenantMainTenant();
        return array(
            'isCurrentTenantMainTenant' => $isCurrentTenantMainTenant,
            'isOtherTenantMainTenant' => !is_null($this->mainTenantData) && ($this->mainTenantData['id']  != $this->tenantId),
            'taxAmountIfMainTenant' => $isCurrentTenantMainTenant ? $this->mainTenantData['taxes'] : null,
            'mainTenantName' => $this->GetMainTenantName(),
            'taxPerYear' => $this->GetTaxAmountPerYear(),
        );
    }

    function StoreTaxBillInfo($billFile, $amount) {
        $filename = $this->GenerateTaxBillFile($billFile['extension']);
        $targetPath = $this->GetTaxBillsPath() . '/' . $filename;
        if (!move_uploaded_file($billFile['filePath'], $targetPath))
            return false;

        $userPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'MainTenantid')->first();
        if (count($userPropertyConstants) > 0) {
            $updateUserPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'MainTenantid')->first();
            $updateUserPropertyConstants->value = $this->tenantId;
            $updateUserPropertyConstants->save();
        } else {
            $insertUserPropertyConstants = new UserPropertyConstant();
            $insertUserPropertyConstants->value = $this->tenantId;
            $insertUserPropertyConstants->property_id = $this->data->property_id;
            $insertUserPropertyConstants->user_id = $this->data->user->id;
            $insertUserPropertyConstants->name = 'MainTenantid';
            $insertUserPropertyConstants->save();
        }

        $userPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'Tenanttaxes')->first();
        if (count($userPropertyConstants) > 0) {
            $updateUserPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'Tenanttaxes')->first();
            $updateUserPropertyConstants->value = $amount;
            $updateUserPropertyConstants->save();
        }else {
            $insertUserPropertyConstants = new UserPropertyConstant();
            $insertUserPropertyConstants->value = $amount;
            $insertUserPropertyConstants->property_id = $this->data->property_id;
            $insertUserPropertyConstants->user_id = $this->data->user->id;
            $insertUserPropertyConstants->name = 'Tenanttaxes';
            $insertUserPropertyConstants->save();
        }
        $userPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'TaxBillLinkToFile')->first();
        if (count($userPropertyConstants) > 0) {
            $updateUserPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'TaxBillLinkToFile')->first();
            $updateUserPropertyConstants->value = $filename;
            $updateUserPropertyConstants->save();
        }else {
            $insertUserPropertyConstants = new UserPropertyConstant();
            $insertUserPropertyConstants->value = $filename;
            $insertUserPropertyConstants->property_id = $this->data->property_id;
            $insertUserPropertyConstants->user_id = $this->data->user->id;
            $insertUserPropertyConstants->name = 'TaxBillLinkToFile';
            $insertUserPropertyConstants->save();
        }

        return true;
    }
    public function GetContractCancellationData() {      // RM   Will need to get data from several different tables.
        $response = array(
            'endDate' => null,
            'startDate' => null,
            'months' => null,
            'cancel3m' => null,
            'cancel6m' => null,
            'cancel1y' => null,
            'deposit' => null,
            'paymentsDue' => null,
            'earlyTerminationFee' => null,
            'charges' => null,
            'credits' => null,
            'totalRentPaid' => null,
            'totalRentDue' => null,
            'depositReturn' => null,
            'uploadedDeregistration' => null
        );

        $fees = $this->GetPossibleEarlyCancellationFees();

        // Check if contract is already cancelled
        $endDate = $this->GetContractEndDate();
        if (!empty($endDate)) {
            $response['endDate'] = $endDate;

            $dp = $this->GetPaymentsDue();
            $paymentsDue = array();
            $totalDue = 0;
            foreach ($dp as $p) {
                $paymentsDue[] = array(
                    'date' => is_null($p['startDate']) ? '' : $p['startDate']->format('j-M-Y'),
                    'description' => $p['description'],
                    'amount' => (float) $p['amount']
                );
                $totalDue += (float) $p['amount'];
            }
            $response['paymentsDue'] = $paymentsDue;
            $response['totalRentDue'] = $totalDue;

            $tf = $this->GetEarlyCancellationFee($endDate);
            $response['earlyTerminationFee'] = (float) $tf['terminationFee'];
            $response['charges'] = (float) $this->GetCurrentCharges();
            $response['credits'] = (float) $this->GetCurrentCredits();

            $allPayments = $this->GetPayments();
            $totalRentPayments = 0;
            foreach ($allPayments as $p) {
                if ((float) $p['amount'] >= 0) {
                    $totalRentPayments += (float) $p['amount'];
                }
            }
            $response['totalRentPaid'] = $totalRentPayments;

            $response['depositReturn'] = $totalRentPayments - $totalDue - $response['charges'] + $response['credits'] - $response['earlyTerminationFee'] + ((float) $fees['deposit']);

            $response['uploadedDeregistration'] = is_null($this->GetDeregistrationProofUrl());
        }
        else {
            $startDate = $this->data->start_date;
            if (empty($startDate)) $startDate = date('Y-m-d');

            $day = date('j');
            $currentMonth = date('n');
            $currentYear = date('Y');
            $startMonth = $currentMonth + (($day < 5) ? 0 : 1);
            $months = array();
            for ($i=$startMonth; $i<=$startMonth+2; $i++) {
                $monthNumber = (($i - 1) % 12) + 1;
                $year = ($monthNumber >= $currentMonth) ? $currentYear : ($currentYear + 1);
                $months[] = array(
                    'index' => $monthNumber,
                    'year' => $year,
                    'lastDay' => date("Y-m-t", strtotime($year . '-' . $monthNumber . '-01'))
                );
            }

            $response['months'] = $months;
            $response['startDate'] = $startDate;
            $response['cancel3m'] = $fees['cancel3m'];
            $response['cancel6m'] = $fees['cancel6m'];
            $response['cancel1y'] = $fees['cancel1y'];
            $response['deposit'] = $fees['deposit'];
        }

        return $response;
    }

    function GetPaymentsDue() {
        $this->LoadRentData();

        $rentEntries = sizeof($this->rentData);

        $result = array();

        // Deposit
        $fees = $this->GetPossibleEarlyCancellationFees();
        $result[] = array(
            'amount' => $fees['deposit'],
            'startDate' => null,
            'description' => 'DEPOSIT DUE'
        );

        // Rent
        for ($i=0; $i < $rentEntries; $i++) {
            $rez = $this->rentData[$i];

            $effDate = $rez->effectiveDate;
            $effDateObj = new \DateTime($effDate);
            $rentPayment = $rez->totalRent;

            $rentStartDate = null;
            $rentNumMonths = null;

            // First check if start day is not last or first day of the month
            $startDay = $effDateObj->format('d');   //  1..31

            //Get last date of effDate month
            $maxDaysInMonth = $effDateObj->format('t'); // 28 .. 31

            if ($i == 0 && $startDay < $maxDaysInMonth && $startDay > 1) { // first row ONLY
                // now calculate the partial month rent to be paid
                $partRentPayment = $rentPayment / $maxDaysInMonth * ($maxDaysInMonth - $startDay + 1);
                $rentStartDay = $startDay;
                $rentEndDay = (INT)$maxDaysInMonth;

                $result[] = array(
                    'amount' => $partRentPayment,
                    'startDate' => $effDateObj,
                    'description' => 'Rent Due day ' . $rentStartDay . ' to ' . $rentEndDay
                );

                // Put in date field on next row
                $nxtMonthDate = new \DateTime($rez->effectiveDate);
                $nxtMonthDate->modify( 'first day of next month' );
                $rentStartDate = $nxtMonthDate;
            }
            else
                $rentStartDate = new \DateTime($rez->effectiveDate);

            // multiply rent by nr of months till contract end date, or next effective date
            // test if more effectiveDates available, otherwise use contractEndDate
            // Assume only one effective date
            $contractEndDateObj = new \DateTime($this->GetContractEndDate());
            $diff = $rentStartDate->diff($contractEndDateObj);
            $rentNumMonths = $diff->m + ceil($diff->d / 30) + ($diff->y*12);

            if ($i+1 < $rentEntries) {
                // More effective dates, take nrMonths between this and next effectivedates
                $nextEffDate =  new \DateTime($this->rentData[$i+1]->effectiveDate);
                $diff = $rentStartDate->diff($nextEffDate);
                $rentNumMonths = $diff->m + ceil($diff->d / 30) + ($diff->y*12);
            }

            $result[] = array(
                'amount' => $rentPayment * $rentNumMonths,
                'startDate' => $rentStartDate,
                'numMonths' => $rentNumMonths,
                'description' => 'Rent Due for ' . $rentNumMonths . ' months ' . 'at Eur ' . $rentPayment
            );
        }

        return $result;
    }


    public function CancelContract($month, $heatingValue, $lrBigHeatingValue, $lrSmallHeatingValue, $expectedDepartureDate, $viewingremarks, $remarks) {
        // Store contract end date and optional move out date to the database
        $endMonth = $month['index'];
        $endYear = $month['year'];
        $monthName = $month['name'];
        $endContractDate = date("Y-m-t", strtotime($endYear . '-' . $endMonth . '-' . '01'));
        $moveOutDatePart = '';
        if (!empty($expectedDepartureDate)) {
            $modParts = explode("-", $expectedDepartureDate);
            $modDb = $modParts[2] . '-' . $modParts[1] . '-' . $modParts[0];
            $moveOutDatePart = ", move_out_date='" . $modDb . "'";
        }
        $state = (int)$this->userInfo->state | self::USER_STATE_ROOM_AVAILABLE;

        $userInfo= UserInfo::where('user_id',  $this->tenantId)->first;
        $userInfo->state = $state;
        $userInfo->save();
        // RM users:state not ported yet. use dummy values.
        $sql="	UPDATE property_tenants SET end_date='" . $endContractDate . "'" . $moveOutDatePart  . " WHERE id=" . $this->tenantId;

        DB::update($sql);

        $tenantName = $this->data->user->name;
        $tenantEmail = $this->data->useer->email;
        $contractStartDate = $this->data->start_date;
        $aptIndex = $this->data->property_id;
        $roomId = $this->data->roomid;

        // Insert nonzero meter values to the database
        $this->storeMeterValue($heatingValue, $roomId, $aptIndex, $this->aptNumber);
        $this->storeMeterValue($lrBigHeatingValue, 'Lb', $aptIndex, $this->aptNumber);
        $this->storeMeterValue($lrSmallHeatingValue, 'Ls', $aptIndex, $this->aptNumber);

        // Send out the email
        $totalMonths = ceil((strtotime($endContractDate) - strtotime($contractStartDate)) / (31 * 24 * 60 * 60));
        $earlyTerminationFeeInfo = $this->GetEarlyCancellationFee($endContractDate);
        $earlyTerminationFee = $earlyTerminationFeeInfo['terminationFee'];
        //Mail send function
        $data = [
            'tenantName' => $tenantName,
            'monthName'  => $monthName,
            'totalMonths' => $totalMonths,
            'earlyTerminationFee' => $earlyTerminationFee,
            'heatingValue' => $heatingValue,
            'lrBigHeatingValue' => $lrBigHeatingValue,
            'lrSmallHeatingValue' => $lrSmallHeatingValue,
            'expectedDepartureDate' => $expectedDepartureDate,
            'viewingremarks' => $viewingremarks,
            'remark' => $remarks
        ];

        Mail::send('emails.Libraries.cancelContract', ['email' => $tenantEmail,  'data' => $data], function ($m) use($tenantEmail) {

            $m->to($tenantEmail)->subject(trans('tenant.cancel_contract'));
        });


        // Update deposit return spreadsheet
        $fees = $this->GetPossibleEarlyCancellationFees();
        $this->createContractCancellationTemplateForTenant($this->tenantId, $earlyTerminationFee, $totalMonths, $fees['deposit']);

        $this->LoadData();
        $this->CreateContractCancellationCalendarEvent();

        return true;
    }
    public function CreateContractCancellationCalendarEvent() {
        global $visitHosts;
        $attendees =  $visitHosts;
        if (!empty($this->data->user->email))
            $attendees[] = $this->data->user->email;

        $endDates = array();
        if (!is_null($this->data->end_date ))
            $endDates[] = strtotime($this->data->end_date);
        if (!is_null($this->data->move_out_date ))
            $endDates[] = strtotime($this->data->move_out_date);
        if (count($endDates) == 0) return;
        $eventDate = min($endDates);
        $eventDate = date('Y-m-d', $eventDate);
        $eventStart = $eventDate . 'T11:00:00';
        $eventEnd = $eventDate . 'T12:00:00';

        $eventText = "Hi " . $this->data->user->name . ",\n\n(1) This is a preliminary key return appointment. Please indicate correct time and accept this event.\n\n(2) Required for your deposit return: On final day, please complete http://Exit.1stHome.nl\n\n(3) Do not leave keys unattended in apartment or with other tenants. Contact Remie at 0685016262 to return them.\n\n(4) Send us government confirmation of your deregistration.\n\nTenant phone: " . $this->userInfo->phone;
        $eventSubject = "Key return: " . $this->GetApartmentName() . " Room: " . $this->data->roomid . " / " . $this->data->user->name;
//        addCalendarEvent($eventSubject, $eventText, $eventStart, $eventEnd, false, $attendees, true, true);
    }

    public function GetHeatingAndElectricityData() {
        $response = array(
            'roomHeatingValue' => $this->getLatestMeterValue($this->data->roomid, $this->data->property_id),
            'bigRadiatorHeatingValue' => $this->getLatestMeterValue('Lb', $this->data->property_id),
            'smallRadiatorHeatingValue' => $this->getLatestMeterValue('Ls', $this->data->property_id)
        );

        return $response;
    }

    public function StoreHeatingAndElectricityData($roomHeatingValue, $bigRadiatorHeatingValue, $smallRadiatorHeatingValue) {
        $aptIndex = $this->data->property_id;
        $roomId = $this->data->roomid;

        $this->storeMeterValue($roomHeatingValue, $roomId, $aptIndex, $this->aptNumber);
        $this->storeMeterValue($bigRadiatorHeatingValue, 'Lb', $aptIndex, $this->aptNumber);
        $this->storeMeterValue($smallRadiatorHeatingValue, 'Ls', $aptIndex, $this->aptNumber);

        return true;
    }

    public function GetRoomCleaningStatus() {
        $result = array(
            'cleaningCharge' => 0,
            'isCleaningRequestActive' => false
        );

        // Get cleaning charge
        $cleaningCharge = $this->getCleaningCharge();
        $result['cleaningCharge'] = is_null($cleaningCharge) ? 0 : abs($cleaningCharge['amount']);

        // Check if there's an active cleaning request
        $roomCleanings = RoomCleaning::where('user_id', $this->tenantId)->orderBy('cleaning_date','DESC')->get();
        if (count($roomCleanings) > 0) {
            $now = time();
            $lastCleaningDate = strtotime($roomCleanings[0]['cleaning_date']);
            if ($lastCleaningDate > ($now - (14 * 24 * 60 * 60)))
                $result['isCleaningRequestActive'] = true;
        }

        return $result;
    }

    public function SubmitRoomCleaningRequest() {
        $cleaningCharge = $this->getCleaningCharge();
        if (is_null($cleaningCharge)) return false;

        // Store a charge for the cleaning
        $insertGeneralCharges = new GeneralCharge();
        $insertGeneralCharges->user_id = $this->tenantId;
        $insertGeneralCharges->amount = $cleaningCharge['amount'];
        $insertGeneralCharges->chargetype =$cleaningCharge['dataProperty'];
        $insertGeneralCharges->comments = '';
        $insertGeneralCharges->date = date('Y-m-d H:i:s') ;
        $insertGeneralCharges->save();
        $chargeId = $insertGeneralCharges->id;

        // Store the cleaning request
        $datetime = new \DateTime('tomorrow');
        $insertRoomCleaning = new RoomCleaning();
        $insertRoomCleaning->user_id = $this->tenantId;
        $insertRoomCleaning->charge_id = $chargeId;
        $insertRoomCleaning->cleaning_date = $datetime->format('Y-m-d H:i:s');
        $insertRoomCleaning->save();

        // Create calendar event
        /*
        $stParts = explode("-", $_POST['vDate']);
        $tParts = explode(":", $_POST['vTime']);
        $endTime = strtotime($_POST['vDate'] . 'T' . $_POST['vTime'] . ':00') + (30 * 60);
        $eventStart = $stParts[2] . '-' . $stParts[1] . '-' . $stParts[0] . 'T' . $tParts[0] . ':' . $tParts[1] . ':00';
        $eventEnd = date('Y-m-d', $endTime) . 'T' . date('H:i', $endTime) . ':00';
        $eventText = "Hi current tenant,\nThe candidate below would like to visit the room. Could you please show the room and apartment?\n(1) If you are available, please accept this request.\n(2) If you are not available - then decline this request. Our host will then do the viewing.\n\nDate: " . $_POST['vDate'] . ' ' . $_POST['vTime'] . "\nApartment: " . $data->apartment_name . ' ' . $data->apartment_nr . "\nRoom: " . $room->room_id . "\nName: " . $_POST['name'] . "\nPhone number: " . $_POST['phone'] . "\nE-mail: " . $_POST['email'] .  "\nLanguage: EN" . "\nRemark: " . $_POST['remark'];
        $eventSubject = $data->apartment_nr . $room->room_id . " visit request : ". $_POST['name'];
        addCalendarEvent($eventSubject, $eventText, $eventStart, $eventEnd, false);
        */

        return true;
    }


    public function CreateEarlyRentPaymentCredit($month, $year) {
        $charge = $this->getEarlyRentPaymentCredit();
        if (is_null($charge)) return false;

        $insertGeneralCharges = new GeneralCharge();
        $insertGeneralCharges->user_id = $this->tenantId;
        $insertGeneralCharges->amount = $charge['amount'];
        $insertGeneralCharges->chargetype =$charge['dataProperty'];
        $insertGeneralCharges->comments = 'Timely rent payment for month ' . $month . '/' . $year;
        $insertGeneralCharges->date = date('Y-m-d H:i:s') ;
        $insertGeneralCharges->save();
        return true;
    }

    public function CreateLateRentPaymentCharge($month, $year) {
        $charge = $this->getLateRentPaymentCharge();
        if (is_null($charge)) return false;

        $insertGeneralCharges = new GeneralCharge();
        $insertGeneralCharges->user_id = $this->tenantId;
        $insertGeneralCharges->amount = $charge['amount'];
        $insertGeneralCharges->chargetype =$charge['dataProperty'];
        $insertGeneralCharges->comments = 'Late rent payment for month ' . $month . '/' . $year;
        $insertGeneralCharges->date = date('Y-m-d H:i:s') ;
        $insertGeneralCharges->save();

        return true;
    }

    public function ServeContract() {
        $contractFile = $this->GetContractFilePath();
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="contract.pdf"');
        readfile($contractFile);
    }


    public function ServeTaxBillImage() {
        $this->LoadMainTenantData();
        $taxBillFile = $this->mainTenantData['taxBillFile'];
        if (!is_null($taxBillFile)) {
            $fullPath = $this->GetTaxBillsPath() . '/' . $taxBillFile;
            header('Content-type: application/jpeg');
            header('Content-Disposition: inline; filename="tax.jpg"');
            $this->ResizeImage($fullPath, 600, NULL);
        }
    }

    public function SubmitHostVisitsPreference($enable) {

        $userInfo = UserInfo::where('user_id', $this->tenantId)->first();
        $userInfo->receive_visit_offers = ($enable ? 1 : 0);
        $userInfo->save();
        $this->LoadData();
    }

    function CheckIfMainTenantExpired() {
        $this->LoadMainTenantData();
        if (!is_null($this->mainTenantData) && !is_null($this->mainTenantData->end_date)) {
            if (strtotime($this->mainTenantData->end_date) < time()) {
                UserPropertyConstant::where('name', 'MainTenantid')->where('property_id', $this->mainTenantData->property_id)->delete();
                UserPropertyConstant::where('name', 'Tenanttaxes')->where('property_id', $this->mainTenantData->property_id)->delete();
                UserPropertyConstant::where('name', 'TaxBillLinkToFile')->where('property_id', $this->mainTenantData->property_id)->delete();
            }
        }

        return true;
    }

    function GetPayments() {
        $this->LoadPaymentData();
        return $this->paymentData;
    }





    /*************************************Private functions *******************************/

    private  function LoadData(){
        $tenants = PropertyTenant::with('user', 'property')->where('user_id', $this->tenantId)->first();
        $userInfo = UserInfo::where('user_id', $this->tenantId)->first();
        $this->data = (count($tenants) == 0) ? null : $tenants;
        $this->userInfo = (count($userInfo) == 0) ? null : $userInfo;
        if (!is_null($this->data)) {
            $this->aptNumber = $this->data->property->street_no;
        }else {
            $this->aptNumber = null;
        }
    }

    private function LoadMainTenantData() {
        if (!$this->mainTenantDataLoaded) {
            $userPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'MainTenantid')->first();
            if (count($userPropertyConstants) == 0)
                $this->mainTenantData = null;
            else {
                $user = User::where('id', $userPropertyConstants->value)->first();
                $this->mainTenantData = (count($user) == 0) ? null : $user;
                if (!is_null($this->mainTenantData)) {
                    $userPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'Tenanttaxes')->first();
                    $this->mainTenantData['taxes'] = count($userPropertyConstants) === 0 ? null : $userPropertyConstants->value;
                    $userPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'TaxBillLinkToFile')->first();
                    $this->mainTenantData['taxBillFile'] = count($userPropertyConstants) === 0 ? null : $userPropertyConstants->value;
                }
            }
            $this->mainTenantDataLoaded = true;
        }
    }

    private function LoadTaxData() {
        if (!$this->taxDataLoaded) {
            $userPropertyConstants = UserPropertyConstant::where('property_id', $this->data->property_id)->where('name', 'Tenanttaxes')->first();
            $this->taxData = (count($userPropertyConstants) == 0) ? 0 : (float) $userPropertyConstants->value;
            $this->taxDataLoaded = true;
        }
    }

    private function getHostRoomVisitCredit() {
//        $hostVisitCreditDataProperty = ConfigManager::Load('config')['hostVisitCreditDataProperty'];

        // Get credit
        $this->LoadStaticChargesData();
        foreach ($this->staticChargesData as $staticCharge) {
            if ($staticCharge['nameEN'] == 'Host a visit') {
                return $staticCharge;
            }
        }
        return null;
    }

    private function GetApartmentJsonFilePath($aptNumber) {
        $path = public_path().'/uploads/docs/' . $aptNumber.'.json';
        return $path;
    }

    private function GetDeRegistrationsPath() {
        $path = public_path().'/uploads/deregistrations';
        return $path;       // RM all these files will come from/go to `documents` table in Rentling.
    }

    private function LoadStaticChargesData() {
        if (!$this->staticChargesDataLoaded) {

//            $roomId = TenantManager::$RoomNameToRoomId[$this->data->roomid];
            $rez = PropertyCharge::where('effective_date', '<=' , date('Y-m-d'))->get();

            // Break the collected data set into subsets, based on the charge type
            $chargeEntriesByType = array();
            foreach ($rez as $r) {
                if (!array_key_exists($r->data_property, $chargeEntriesByType))
                    $chargeEntriesByType[$r->data_property] = array();
                $chargeEntriesByType[$r->data_property][] = $r;
            }


            // Find the active charge entry for each charge type (most recent AND specific one per type)
            $activeChargeByType = array();
            foreach ($chargeEntriesByType as $chargeType => $chargeEntries) {
                $mostSpecificEntry = $chargeEntries[0];
                for ($i=1; $i<count($chargeEntries); $i++) {
                    if ($this->IsFirstStaticChargeMoreSpecificThanSecond($chargeEntries[$i], $mostSpecificEntry))
                        $mostSpecificEntry = $chargeEntries[$i];
                }
                $activeChargeByType[$chargeType] = $mostSpecificEntry;
            }

            $this->LoadChargeTypesData();

            $this->staticChargesData = array();
            foreach ($activeChargeByType as $chargeType => $charge) {
                $this->staticChargesData[] = array(
                    'dataProperty' => $chargeType,
                    'nameEN' => $this->chargeTypesData[$chargeType]->nameEN,
                    'nameNL' => $this->chargeTypesData[$chargeType]->nameNL,
                    'amount' => $charge->value,
                );
            }
            $this->staticChargesDataLoaded = true;
        }
    }

    private function IsFirstStaticChargeMoreSpecificThanSecond($charge1, $charge2) {
        $charge1Score = (is_null($charge1->property_id) ? 0 : 1);
        $charge2Score = (is_null($charge2->property_id) ? 0 : 1);
        return $charge1Score > $charge2Score;
    }

    private function LoadChargeTypesData() {
        if (!$this->chargeTypesDataLoaded) {
            $rez = DataProperty::where('type' , 'RoomCharge')->get();
            $this->chargeTypesData = array();
            foreach ($rez as $r){
                $nameENResult = DataPropertyName::where('data_property_id', $r->id)->where('language_code', 'EN')->first();
                $nameNLResult = DataPropertyName::where('data_property_id', $r->id)->where('language_code', 'NL')->first();
                $r->nameEN = $nameENResult->name;
                $r->nameNL = $nameNLResult->name;
                $this->chargeTypesData[$r->value] = $r;
            }
            $this->chargeTypesDataLoaded = true;
        }
    }

    private function GenerateTaxBillFile($extension) {
        return 'apt' . $this->data->property_id . '_tn' . $this->tenantId . '.' . $extension;
    }

    private function GetTaxBillsPath() {
        $path = public_path().'/uploads/taxbills';
        return $path;
    }
    private function LoadRentData() {
        if (!$this->rentDataLoaded) {
            $rents = Rent::where('user_id', $this->tenantId)->orderBy('effectiveDate')->get();
            $this->rentData = $rents;
            $this->rentDataLoaded = true;
        }
    }

    private function storeMeterValue($value, $roomId, $aptIndex, $aptNr) {
        if (!empty($value)) {
            $insertUtilityMeters = new UtilityMeter();
            $insertUtilityMeters->property_id = $aptIndex;
            $insertUtilityMeters->value_date = date('Y-m-d');
            $insertUtilityMeters->meternr = '';
            $insertUtilityMeters->meter_value = $value;
            $insertUtilityMeters->remark = $roomId;
            $insertUtilityMeters->save();
        }
    }

    function createContractCancellationTemplateForTenant($userId, $earlyTerminationFee, $totalMonths, $deposit) {

    }

    private function getLatestMeterValue($roomId, $aptIndex) {
        $utilityMeters = UtilityMeter::where('property_id', $aptIndex)->orderBy('timestamp','desc')->get();
        return count($utilityMeters) > 0 ? $utilityMeters[0]->meter_value : null;
    }

    private function getCleaningCharge() {
        // Get cleaning charge
        $this->LoadStaticChargesData();
        foreach ($this->staticChargesData as $staticCharge) {
            if ($staticCharge['nameEN'] == 'Room cleaning') {
                return $staticCharge;
            }
        }
        return null;
    }

    private function getEarlyRentPaymentCredit() {
        // Get credit
        $this->LoadStaticChargesData();
        foreach ($this->staticChargesData as $staticCharge) {
            if ($staticCharge['nameEN'] == 'Early rent payment') {
                return $staticCharge;
            }
        }
        return null;
    }

    private function getLateRentPaymentCharge() {
        // Get charge
        $this->LoadStaticChargesData();
        foreach ($this->staticChargesData as $staticCharge) {
            if ($staticCharge['nameEN'] == 'Late rent payment') {
                return $staticCharge;
            }
        }
        return null;
    }

    private function GetContractFilePath() {
        $path = public_path().'/uploads/contracts/' . $this->data->path;
        return $path;
    }

    private function LoadPaymentData() {
        if (!$this->paymentDataLoaded) {
            $payments = Payment::where('tenant_id', $this->tenantId)->orderBy('updated_at','asc')->get();
            $this->paymentData = $payments;
            $this->paymentDataLoaded = true;
        }
    }
    private function ResizeImage($filename, $width, $height) {
        list($width_orig, $height_orig, $type) = getimagesize($filename);
        $ratio_orig = $width_orig/$height_orig;

        if (!is_null($width))
            $height = $width / $ratio_orig;
        else
            $width = $height * $ratio_orig;

        // Resample
        $image_p = imagecreatetruecolor($width, $height);
        if ($type === IMG_JPG)
            $image = imagecreatefromjpeg($filename);
        else
            $image = imagecreatefrompng($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        // Output
        imagejpeg($image_p, null, 100);
    }
}