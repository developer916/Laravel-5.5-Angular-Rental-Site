<?php
/**
 * Created by PhpStorm.
 * User: cos
 * Date: 03/12/15
 * Time: 13:57
 */

namespace App\Http\Services;


use App\Models\Property;
use App\Models\RentContract;
use App\Models\UserPropertyConstant;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ContractTemplateService
{
    protected $request;
    protected $userService;

    public function __construct(\Illuminate\Http\Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    public function save()
    {
        // dd($this->request->all());
        // exit;
        if (!$this->request->get('id')) {   // update
            $record = new RentContract();            
            $record->user_id = Auth::user()->id;
            $record->country_id = $this->request->get('countryId');                
            $record->contract_type_id = $this->request->get('contractTypeId');   
            $record->property_id = $this->request->get('propertyId');        
            $record->use_as_addendum = $this->request->get('useAsAddendum') ? 1 : 0;            
            $record->template = $this->request->get('template');
            $record->language_id = 1;   
            $status = $record->save(); 
        } else {                            // create
            $record = RentContract::where('id', $this->request->get('id'))->first();
            if ($record) {                
                $record->user_id = Auth::user()->id;
                $record->country_id = $this->request->get('countryId');                
                $record->contract_type_id = $this->request->get('contractTypeId');   
                $record->property_id = $this->request->get('propertyId');        
                $record->use_as_addendum = $this->request->get('useAsAddendum') ? 1 : 0;
                $record->template = $this->request->get('template');
                $record->language_id = 1;   
                $status = $record->save();                
            }
        }

        return [
            'status' => $status,
            'data' => [
                'id' => $record->id,
            ]
        ];

    }

    public function view($typeId, $countryId, $propertyId)
    {
        
        if($typeId == 1) {            
            $record = RentContract::where('contract_type_id', $typeId)->where('country_id', $countryId)->first();
        } else {
            $record = RentContract::where('contract_type_id', $typeId)->where('country_id', $countryId)
                        ->where('user_id', Auth::user()->id)->where('property_id', $propertyId)->first();
        }        
        
        return [
            'status' => ($record) ? 1 : 0,
            'data' => $record
        ];
    }

    public function getFormFields($typeId)
    {
        $fields = UserPropertyConstant::where('user_id', Auth::user()->id);
        if($typeId == 2) {
            $fields->whereNull('property_id');
        } else {
            $fields->whereNotNull('property_id');
        }                
        $records = $fields->orderBy('name', 'asc')->get(['id', 'name']);

        $usedNames = array();
        $formFields = array();
        foreach ($records as $rec) {                                
            if(!in_array($rec->name, $usedNames)) {                
                array_push($formFields, $rec);    
                array_push($usedNames, $rec->name);                
            }    // prevent from record duplicated                         
            
        } 
        return $formFields;                
    }
}