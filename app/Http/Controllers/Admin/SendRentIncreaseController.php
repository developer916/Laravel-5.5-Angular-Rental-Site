<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Mail\sendRentIncrease;
use App\Models\PropertyTransaction;
use App\Models\PropertyTenant;
use App\Models\Property;
use DB;
use Auth;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use App\Models\Profile;
use Mail;

/*
feature/REN-49
Rentling will not use JSON files for specific property information. This was used in old system.
Remove use of JSON files and use info from Rentling tables.

On highest level, current idea is:
1. The property specifies how rent should be calculated ( effective date should be elsewhere as a landlord parameter, see below)
2. Landlord attributes determine rent price on second level (rent components etc)
3. Regulation on the 3rd level. e.g. NL law says you can add 5% of service cost as administration fee.  DE law says you should subtract Y from Z. Those rules go in a property_laws table.
*/

class SendRentIncreaseController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRoleMethod($user){
        return is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
    }

    public function getList(Request $request){
        // Retrieve active contracts. Will return JSON file with total rent values, and list of tenants including their new rent.
        $rentCalcDate = $request->get("effectiveDate");
        $calcMonth = date('n')+3;
        if (is_null($rentCalcDate)) $rentCalcDate = date('01-' . $calcMonth . '-Y');

        $sql = 'SELECT property_tenants.*, users.id as userID, users.name , users.email , 0 as currentRent, 0 as currentService, 0 as percentDiff FROM `property_tenants` left join users on property_tenants.user_id = users.id WHERE property_tenants.end_date is null and users.parent_id ='.Auth::user()->id;
        $retrieveContracts = DB::select($sql);

        $data = [];

        if(count($retrieveContracts) >0) {
            $calcMonth = date('n')+5;
            $data = [
                                'tenants' => $retrieveContracts,
                                'totalCurRent'  => 0,
                                'totalNewRent'  => 0,
                                'totalDiff'  => 0,
                                'totalPercentDiff'  => 0,
                                'effectiveDate' => $rentCalcDate,
                                'startDate'     => date('d-m-Y'),
                                'endDate'       => date('01-' . $calcMonth . '-Y'),
                                'emailSubject'  => 'Melding huurverhoging per '. $rentCalcDate .' / Notice of rent increase per '. $rentCalcDate,
                                'emailBody'     => 'Beste %name,&#13;&#10;Wij volgen de jaarlijkse overheidsrichtlijnen voor huurprijzen waardoor je huur ingaande '. $rentCalcDate  .' wordt aangepast naar %newRentAmount. Hierbij verzoek dit bedrag te voldoen vanaf je betaaldatum voor die periode. De bijbehorende wettelijke melding zoals voorgeschreven door de huurwet, die deze aanpassing onderbouwt staat in je huurdersdashboard in www.Rentling.nl&#13;&#10;&#13;&#10;============== English ===================&#13;&#10;&#13;&#10;Dear %name,&#13;&#10;We follow government mandated yearly guide lines causing your rent to adjust to %newRentAmount from '. $rentCalcDate  .' and onwards. Please pay this amount starting the pay date for that period. The official notice (as required by law) specifying this change is in your tenant dashboard at www.Rentling.nl&#13;&#10;&#13;&#10;Regards,&#13;&#10;' . Auth::user()->name
            ];
            $userIds = array();
            foreach ($retrieveContracts as $tenant){
                $userIds[] = $tenant->userID;
            }

            $sql = 'select id, post_code, street_no, unit from properties where user_id ='.Auth::user()->id;
            $currentProperties = DB::select($sql);

            $rentByUser = $this->getExistingRoomRentOnDate( $userIds, time() );
            foreach ( $retrieveContracts as $tenant ) {                          // update rent amounts in list of property_tenants
                $tenant->currentRent = $rentByUser[$tenant->user_id]['total'];
                $tenant->currentService = $rentByUser[$tenant->user_id]['service'];

                // Get the room info
                for ($j=0; $j < count($currentProperties); $j++) {                   // Find property or fail
                    if ($currentProperties[$j]->id == $tenant->unit_id) {
                        $tenant->room = $currentProperties[$j]->street_no . '-' . $currentProperties[$j]->unit;
                        break;
                    }
                }

                // note that we are giving the unit_id, instead of the property_id
                $rentSpecs = $this->calculateRoomRent($tenant->unit_id, \DateTime::createFromFormat('d-m-Y', $rentCalcDate)->getTimestamp());
                $tenant->rent = $rentSpecs['total'];
                $tenant->service = $rentSpecs['service'];
                if($tenant->currentRent != 0) {
                    $tenant->percentDiff = number_format(( $tenant->rent - $tenant->currentRent )/ $tenant->currentRent * 100, 2);
                }else {
                    $tenant->percentDiff = 0;
                }
                $data[ 'totalCurRent' ] += $tenant->currentRent;
                $data[ 'totalNewRent' ] += $rentSpecs['total'];                
            }
            $data[ 'totalDiff' ] = $data[ 'totalNewRent' ] - $data[ 'totalCurRent' ];
            if($data['totalCurRent'] != 0) {
                $data[ 'totalPercentDiff' ] = number_format( $data[ 'totalDiff' ] / $data[ 'totalCurRent' ] * 100, 2);
            }else {
                $data[ 'totalPercentDiff' ] = 0;
            }

            $data[ 'totalDiff' ] = number_format( $data[ 'totalDiff' ], 2);
            $data[ 'totalCurRent' ] = number_format($data[ 'totalCurRent' ], 2);
            $data[ 'totalNewRent' ] = number_format($data[ 'totalNewRent' ], 2);
            
        } else {
            // Show dummy tenant 
            $data = [    
                    'tenants' => [
                        [
                        'userID'=> '1',
                        'name'=> '** VOORBEELD HUURDER **',                              // trans('EXAMPLE_TENANT'),   
                        'email' => Auth::user()->email,
                        'currentRent' => 500,
                        'currentService'=> 100,
                        'service'  => 105,
                        'rent' => 515,
                        'room' => '1234AB-nr 35',
                        'percentDiff'=> 3,
                        'property_id' => 1,
                        'user_id' => 1,
                        'unit_id' => 1 
                        ]
                    ],
                    'totalCurRent'  => 500,
                    'totalNewRent'  => 515,
                    'totalDiff'  => 15,
                    'totalPercentDiff'  => 3,
                    'effectiveDate' => $rentCalcDate,
                    'startDate'     => date('d-m-Y'),
                    'endDate'       => date('01-' . $calcMonth . '-Y'),
                    'emailSubject'  => '** Voorbeeld huurverhoging **',                 // trans('SAMPLE_RENT_INCREASE_MSG'),
                    'emailBody'     => 'Beste '. Auth::user()->name . ', hier verschijnt later het e-mail bericht waarmee u huurverhogingen aan huurders meldt. U ziet momenteel geen informatie omdat u geen huurders heeft ingevoerd. Voeg alsnog uw locaties en huurder(s) toe. U kunt wel alvast een voorbeeld huurverhoging aan uzelf mailen. Rentling verstuurt huurverhogingen zowel in het Nederlands als Engels.&#13;&#10&#13;&#10Dear '. Auth::user()->name . ', This area will later display the rent increase announcement you will send to tenants. For your convenience, the rent increases will be sent in Dutch and English. Please add your locations and tenants to activate this screen. You can already send a test version to your e-mail.&#13;&#10&#13;&#10;Met vriendelijke groet / Regards,&#13;&#10;Rentling Group'
            ];
        }
        return response()->json($data);
    }

    public function getExistingRoomRentOnDate($userId, $date) {  // return array or rent values, service cost, and their sum.
        if (!is_array($userId)) $userId = array($userId);
        $sql = "select user_id, amount_total as totalRent, service_cost as serviceCost, UNIX_TIMESTAMP(effective_date) as rentDate from property_transactions where user_id IN (" . implode(',', $userId) . ") order by user_id, effective_date desc";
        $rez = DB::select($sql);
/*
EXAMPLE SQL AND OUTPUT
select user_id, totalRent, serviceCost, UNIX_TIMESTAMP(effectiveDate) as rentDate from rent where user_id IN (236, 240 ) order by user_id, effectiveDate desc;
user_id totalRent   serviceCost rentDate
236 564.11  282.95  1498867200
236 554.11  272.95  1467331200
236 538.18  267.70  1441065600
236 538.18  174.70  1441065600
240 588.68  276.39  1498867200
240 578.68  266.39  1467331200
240 562.11  261.14  1443657600
240 562.11  168.13  1443657600
*/
        $rentValuesByUser = array();                        // We are/could be processing multiple tenants, with multiple rent amounts.
        for ($j=0; $j<sizeof($rez); $j++)                   // For each user
        {
            if (!array_key_exists($rez[$j]->user_id, $rentValuesByUser))  
                $rentValuesByUser[$rez[$j]->user_id] = array();    
            $rentValuesByUser[$rez[$j]->user_id][] = $rez[$j];   

        }
        $result = array();
        foreach ($userId as $u) {
            $result[$u] = array(      // Initialize array of array containing rents, service and totals, using user_id as index
                'rent'      => 0,
                'service'   => 0,
                'total'     => 0
            );
        }
        foreach ($rentValuesByUser as $uId => $rents) {
            // $rents are already in descending date order
            foreach ($rents as $rent) {
                if ($rent->rentDate <= $date) {
                    $result[$uId]['total'] = number_format($rent->totalRent, 2);
                    $result[$uId]['service'] = number_format($rent->serviceCost, 2);
                    $result[$uId]['rent'] = number_format((float)$result[$uId]['total'] - (float)$result[$uId]['service'], 2);
                    break;
                }
            }
        }
//        return count($userId) > 1 ? $result : $result[$userId[0]];
        return $result;
    }

    public function calculateRoomRent($propertyID, $calcDate = NULL)
    {
        $baseGovtRentDataProperty = 0;

        // Later we will query property_laws table on how to calculate  rent, instead of making assumption below.
        $sql_govement_rent = "SELECT * FROM `data_property_names` left join data_properties on data_properties.id = data_property_names.data_property_id where data_property_names.name='Government base rent'";
        $results = DB::select($sql_govement_rent);
     
        if(count($results) >0) {
            $baseGovtRentDataProperty = $results[0]->value;
        }
        $furnishedSurplusDataProperty = 0;
        $sql_govement_rent = "SELECT * FROM `data_property_names` left join data_properties on data_properties.id = data_property_names.data_property_id where data_property_names.name='Furnished surplus'";
        $results = DB::select($sql_govement_rent);
        if(count($results) >0) {
            $furnishedSurplusDataProperty = $results[0]->value;
        }
        $property = Property::findOrFail($propertyID);
    
        $landlord = $property->user_id;  // Note: $property->user_id will be the landlord, not the tenant. They are in property_tenants.
        
        if (is_null($calcDate)) $calcDate = time();       

        $nr_units = 1;                      // Assume we are calculating for 1 unit, being the whole property.
        $targetProperties = array($propertyID);
        
        if (!is_null($property->parent_id)) { // We can now safely query on parent_id for total units.
            $nr_units = count( DB::select( "SELECT * FROM properties where parent_id = " . $property->parent_id ) ); 
            $targetProperties[] = $property->parent_id; // We are calculating for a unit, so include the parent in the query.
        }

        $sql = "SELECT * FROM rent_components WHERE effective_date <= '" . date('Y-m-d', $calcDate) . "'  AND (user_id= " . $landlord . ") AND (property_id IS NULL OR (property_id IN (" . implode(',', $targetProperties) . ")))";
        $rez = DB::select($sql);
/*
id  user_id property_id data_property   value   effective_date
128 5       NULL        21              93.00   2000-01-01
663 5       NULL        19              240.00  2016-04-01
668 5       NULL        8               163.00  2016-05-01
669 5       NULL        21              103.00  2016-11-15
676 5       NULL        21              125.00  2017-08-01
609 5       63          20              298.95  2000-01-01
634 5       63          20              310.23  2016-04-01
671 5       63          20              316.74  2017-07-01
*/   

        // Later, we will rewrite into:
        // (1) Get list of amenities, for property and unit.
        // (2) ForEach amenities , if its in rent components, then add rent amount from rent components table to the final rent calculation.
        // Lets get this code version working first, then we can rewrite.
        $sql_amenities = "SELECT * FROM `property_amenities` left join amenities on property_amenities.amenity_id= amenities.id where property_amenities.property_id = ".$propertyID." and amenities.title='Furnished'";
        $result_amenities = DB::select($sql_amenities);
        $kale = 0;
        $furnishedSurplus = 0;
        $aptCosts = array();
        $baseRents = array();
        $furnishedSurpluses = array();
        for ($j = 0; $j < sizeof($rez); $j++) {
            if ($rez[$j]->data_property == $baseGovtRentDataProperty) {
                $baseRents[] = $rez[$j];
            } else if (($rez[$j]->data_property == $furnishedSurplusDataProperty) && (count($result_amenities)> 0)) {
                $furnishedSurpluses[] = $rez[$j];
            } else if (!is_null($rez[$j]->property_id)) {
                if (!array_key_exists($rez[$j]->data_property, $aptCosts))
                    $aptCosts[$rez[$j]->data_property] = array();
                $aptCosts[$rez[$j]->data_property][] = $rez[$j];
            }
        }

        usort($baseRents, array($this, "dateDescSortCmp"));
        if(count($baseRents) >0){
            $kale = (float) $baseRents[0]->value;
        }
        usort($furnishedSurpluses, array($this, "dateDescSortCmp"));
        if (count($furnishedSurpluses) > 0)
            $furnishedSurplus = (float) $furnishedSurpluses[0]->value;
        $aptTotalService = 0;
        foreach ($aptCosts as $dataProp => $values) {
            usort($values, array($this, "dateDescSortCmp"));
            $aptTotalService += (float) $values[0]->value;
        }

        $service = $furnishedSurplus + (($aptTotalService / $nr_units / 12)) * 1.05;  
        // Move 5% addition to property_laws table, or rent components as a default.
    
        return array(
            'rent'      => number_format($kale, 2),
            'service'   => number_format($service, 2),
            'total'     => number_format($kale + $service, 2)
        );
    }

    private function dateDescSortCmp($a, $b)
    {
        $da = new \DateTime($a->effective_date);
        $db = new \DateTime($b->effective_date);
        if ($da == $db) return 0;
        return $db < $da ? -1 : 1;
    }

    public function postCreate(Request $request){
        if($request->has('startData')){
            $startDate =date('Y-m-d', strtotime($request->get('startData'))); ;
        }else {
            $startDate = date('Y-m-d');
        }
        if($request->has('endDate')){
            $endDate =date('Y-m-d', strtotime($request->get('endDate')));
        }else {
            $endDate = date('Y-09-1');
        }
        if($request->has('effectiveDate')){
            $effectiveDate = date('Y-m-d', strtotime($request->get('effectiveDate')));
        }else {
            $effectiveDate = date('Y-07-1');
        }
        $subject = $request->get('emailSubject');
        $body = $request->get('emailBody');
        $tenants = $request->get('tenants');
        $sendMethod = $request->get('sendMethod');
        if(count($tenants)>0) {
            $sendBodyLandlord = '';
            foreach($tenants as $tenant){
                // TODO: move the following HTML to a view. Don't do inline HTML processing in the controller.
                $html = '<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm">
                        <table style=\"width: 100%\">
                            <tr>
                             <td align=\"right\"> <img src="#logo#" width="52" height="62">
                             </td>
                            </tr>
                            <tr>
                             <td align=\"right\">#landlordname# <br>#landlordaddress# <br>#landlordemail# <br>#landlordcity# #landlordcountry# 
                             </td>
                            </tr>                                
                        </table>
                         <table>
                            <tr>
                                <td><h2>Proposal to yearly rent increase</h2></td>
                            </tr>
                         </table>
                         <table>
                            <tbody>
                                <tr>
                                    <td> <p>Name tenant</p> </td>
                                    <td> <p >#username#</p> </td>
                                </tr>
                                <tr>
                                    <td> <p>Address</p> </td>
                                    <td> <p>#apartmentname# #apartmentnr#, #roomid#</p> </td>
                                </tr>
                                <tr>
                                    <td> <p>&nbsp;</p> </td>
                                    <td> <p>&nbsp;</p> </td>
                                </tr>
                                <tr>
                                    <td> <p>&nbsp;</p> </td>
                                    <td> <p>&nbsp;</p> </td>
                               </tr>
                               <tr>
                                      <td> <p>Date</p> </td>
                                      <td> <p>#today#</p> </td>
                                 </tr>
                              </tbody>
                           </table>
                           <p>Dear tenant,</p> <p>The rent of your room will be changed as proposed</p>
                           <table cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">
                              <tbody>
                                  <tr>
                                      <td> <p>Date of change:</p> </td>
                                      <td colspan=\"3\"> <p>#effectivedate#</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>Amount of change:</p> </td>
                                      <td> <p><span>&euro; </span>#rentdelta#</p> </td>
                                      <td> <p>Percentage:</p></td>
                                      <td> <p>#rentdeltapercent#%</p> </td>
                                  </tr>
                                  <tr>
                                      <td colspan=\"4\"> <p>&nbsp;</p> </td>
                                  </tr>
                              </tbody>
                           </table>
                           <p>The increase is in accordance with guide lines of the Dutch rental law.</p>
                           <table cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">
                              <tbody>
                                  <tr>
                                      <td> <p>&nbsp;</p> </td>
                                      <td> <p>Old rent price</p> </td>
                                      <td> <p>New rent price</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>Base rent per month</p> </td>
                                      <td> <p><span>&euro; </span>#oldbaserent#</p> </td>
                                      <td> <p><span>&euro; </span>#newbaserent#</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>General cost for (building) management,<br>heating, taxes, repairs etc.</p> </td>
                                      <td> <p><span>&euro; </span>#oldservicecost#</p> </td>
                                      <td> <p><span>&euro; </span>#newservicecost#</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>Total rent amount</p> </td>
                                      <td> <p><span>&euro; </span>#totalcurrent#</p> </td>
                                      <td> <p><span>&euro; </span>#totalnewrent#</p> </td>
                                  </tr>
                              </tbody>
                           </table>
                           <p><small>If you object to this change, then you have the right to notify me via e-mail before the effective date mentioned above. Please note that your objection will have to be clearly motivated and follow the rules of Dutch rental law, specifying the rental rules that land lord does not follow.</small></p>
                           <p><small>Also, when calculating the \'service cost\' as defined by the Dutch rental commission, you should omit government taxes for garbage, water supply, sewage etc. These cost are not part of service cost as defined by law, but are still borne by tenants.</small></p>
                        </page>
                        <!--  NL VERSION  -->
                        <page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm">
                          <table style=\"width: 100%\">
                              <tr>
                               <td align=\"right\"> <img src="#logo#" width="52" height="62">
                               </td>
                              </tr>
                              <tr>
                               <td align=\"right\">#landlordname# <br>#landlordaddress# <br>#landlordemail# <br>#landlordcity# #landlordcountry# 
                               </td>
                            </tr>                                
                        </table>
                         <table>
                            <tr>
                                <td><h2>Aanzegging huurverhoging (on)zelfstandige woonruimte</h2></td>
                            </tr>
                         </table>
                         <table>
                            <tbody>
                                <tr>
                                    <td> <p>Naam huurder</p> </td>
                                      <td> <p >#username#</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>Adres gehuurde</p> </td>
                                      <td> <p>#apartmentname# #apartmentnr#, #roomid#</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>&nbsp;</p> </td>
                                      <td> <p>&nbsp;</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>&nbsp;</p> </td>
                                      <td> <p>&nbsp;</p> </td>
                                 </tr>
                                 <tr>
                                      <td> <p>Date</p> </td>
                                      <td> <p>#today#</p> </td>
                                 </tr>
                              </tbody>
                           </table>
                           <p>Geachte heer/mevrouw,</p> <p>Hierbij stel ik u voor de huurprijs van de door u gehuurde woonruimte per #effectivedate# te verhogen met #rentdelta# %.</p>
                           <table cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">
                              <tbody>
                                  <tr>
                                      <td> <p>Ingangsdatum nieuwe huur:</p> </td>
                                       <td colspan=\"3\"> <p>#effectivedate#</p> </td>
                                   </tr>
                                   <tr>
                                       <td> <p>Bedrag van wijziging:</p> </td>
                                       <td> <p><span>&euro; </span>#rentdelta#</p> </td>
                                       <td> <p>Percentage:</p></td>
                                       <td> <p>#rentdeltapercent#%</p> </td>
                                   </tr>
                                   <tr>
                                       <td colspan=\"4\"> <p>&nbsp;</p> </td>
                                   </tr>
                               </tbody>
                            </table>
                            <p>Deze verhoging is conform wettelijke richtlijnen.</p>
                           <table cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%\">
                              <tbody>
                                  <tr>
                                      <td> <p>&nbsp;</p> </td>
                                      <td> <p>Huidig bedrag</p> </td>
                                      <td> <p>Niew bedrag</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>Kale huurprijs per maand</p> </td>
                                      <td> <p><span>&euro; </span>#oldbaserent#</p> </td>
                                      <td> <p><span>&euro; </span>#newbaserent#</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>Algemene kosten voor onderhoud gebouw, management,<br>verwarming, belastingen, reparaties etc.</p> </td>
                                      <td> <p><span>&euro; </span>#oldservicecost#</p> </td>
                                      <td> <p><span>&euro; </span>#newservicecost#</p> </td>
                                  </tr>
                                  <tr>
                                      <td> <p>Totale huur per maand</p> </td>
                                      <td> <p><span>&euro; </span>#totalcurrent#</p> </td>
                                      <td> <p><span>&euro; </span>#totalnewrent#</p> </td>
                                  </tr>                                    
                              </tbody>
                           </table>
                           <p><small>Indien u bezwaar heeft tegen deze aanpassing dan kunt u ten eerste mij als verhuurder daarvan inlichten door een bezwaarschfrifint e vullen dat verkrijgbaar is bij de Huurcommissie. U kunt dat bezwaarschrift indienen tot de datum waarop de voorgestelde verhoginingaat.</small>
                           </p>
                           <p><small>Bovendien, bij berekening van \'service kosten\' zoals gedefinieerd door de Huurcommissie, moet u de gemeentelijke belastingebuiten beschouwing laten. Deze zijn wettelijk geen onderdeel van de servicekosten maar worden desondanks gedragen door huurders.</small>
                           </p>
                        </page>';


                    $profile = Profile::where('user_id', Auth::user()->id)->first();
                    if(count($profile) >0) {
                        $html = str_replace('#logo#', $profile->avatar , $html);
                        $html = str_replace('#landlordaddress#', $profile->address, $html);
                        $html = str_replace('#landlordcity#', $profile->city, $html);
                        $html = str_replace('#landlordcountry#', $profile->country, $html);
                    }else {
                        $html = str_replace('#logo#', 'https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/1stHomeLogo-body-only.png' , $html);
                        $html = str_replace('#landlordaddress#','', $html);
                        $html = str_replace('#landlordcity#', '', $html);
                        $html = str_replace('#landlordcountry#', '', $html);
                    }

                    $unit_id = $tenant['unit_id']; // for main apt, will equal property_id

                    $newBaseRent = $tenant['rent'] - $tenant['service'];  // minus service and furnishedsurplus
                    $oldBaseRent = (float) $tenant['currentRent'] - (float) $tenant['currentService'];

                    // Calculate rent diff
                    $rentDiff = (float)$tenant['rent'] - (float)$tenant['currentRent'];

                    $html = str_replace('#landlordname#', Auth::user()->name, $html);
                    $html = str_replace('#landlordemail#', Auth::user()->email, $html);
                    $html = str_replace('#username#', $tenant['name'], $html);

                    $property = Property::where('id', $unit_id)->first();
                    if ($property) {
                        $html = str_replace('#apartmentname#', $property->address, $html);
                        $html = str_replace('#apartmentnr#', $property->street_no, $html);
                        $html = str_replace('#roomid#', $property->unit, $html);   // needs check on NULL in case of non-unit?
                    }
                    $html = str_replace('#today#', date('d F Y'), $html);
                    $html = str_replace('#effectivedate#', \DateTime::createFromFormat('Y-m-d', $effectiveDate)->format('d F Y'), $html);

                    $html = str_replace('#rentdelta#', $rentDiff, $html);
                    $html = str_replace('#rentdeltapercent#', $tenant['percentDiff'], $html);
                    $html = str_replace('#oldbaserent#', number_format( $oldBaseRent, 2), $html);
                    $html = str_replace('#newbaserent#', $newBaseRent, $html);
                    $html = str_replace('#oldservicecost#', $tenant['currentService'], $html);
                    $html = str_replace('#newservicecost#', $tenant['service'], $html);

                    $html = str_replace('#totalcurrent#', $tenant['currentRent'], $html);
                    $html = str_replace('#totalnewrent#', $tenant['rent'], $html);

                    $finalBody = str_replace('%name', $tenant['name'], $body);
                    $finalBody = str_replace('%newRentAmount', $tenant['rent'], $finalBody);

                    if ($sendMethod == "to-landlord") {
                        $finalBody = str_replace('%name', $tenant['name'], $body);
                        $finalBody = str_replace('%newRentAmount', $tenant['rent'], $finalBody);
                        $sendBodyLandlord .= $finalBody ."\n\n" . $html;
                    } else {
                        if ($property) {   // don't store test cases for new landlords
                            $html2pdf = new Html2Pdf('P', 'A4', 'en');
                            $html2pdf->WriteHTML($html);
                            $pdfFilename = time() . '_' . uniqid() . '.pdf';
                            if (!file_exists(public_path() . '/uploads/rent_increases')) {
                                mkdir(public_path() . '/uploads/rent_increases', 0777, true);
                            }
                            $fullPdfFilename = public_path() . "/uploads/rent_increases" . '/' . $pdfFilename;
                            $pdfcontent = $html2pdf->output($fullPdfFilename,'S');
                            $f = fopen($fullPdfFilename, 'wb');
                            fwrite($f, $pdfcontent);
                            fclose($f);
    
                            $propTransAction = new PropertyTransaction();
                            $propTransAction->property_id = $tenant['property_id'];
                            $propTransAction->unit_id = $tenant['unit_id'];
                            $propTransAction->user_id = $tenant['user_id'];
                            $propTransAction->transaction_category_id = 1;
                            $propTransAction->transaction_recurring_id = 3;
                            $propTransAction->amount = $newBaseRent;
                            $propTransAction->amount_total = $tenant['rent'];
                            $propTransAction->description = 'Montly rent';
                            $propTransAction->service_cost = $tenant['service'];
                            $propTransAction->notification_active_from = $startDate;
                            $propTransAction->notification_active_to = $endDate;
                            $propTransAction->effective_date = $effectiveDate;
                            $propTransAction->notification_document = $pdfFilename;
                            $propTransAction->save();
                        }
                        Mail::to( $tenant['email'] )->send(new sendRentIncrease($finalBody, $subject));
                    }
                }

                if($sendMethod == "to-landlord") {
                    $sendBodyLandlord = "LET OP: DIT IS EEN TEST. Uw huurverhogingen zijn nog niet naar uw huurders verstuurd.\n\nNOTE: This is a test message. Your rent increases have not been sent to your tenant(s).\n\n'" . $sendBodyLandlord;
                    Mail::to(Auth::user()->email)->send(new sendRentIncrease($sendBodyLandlord, $subject . ' TEST'));
                }
        }
        return response()->json(['status' => 0]);
    }
}
