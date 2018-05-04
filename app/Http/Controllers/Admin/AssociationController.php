<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Services\PropertyService;
use App\Models\Association;
use Auth;
use App\Http\Controllers\Controller;

class AssociationController extends Controller
{
    //    
    public function getPropertiesWithCountry(PropertyService $service, $country_id)
    {
        return response()->json($service->getAuthUserPropertiesWithCountry($country_id));
    }

    // postCreate

    public function postCreate()
    {	
        
        $record = new Association();            
        $record->user_id = Auth::user()->id;
        $record->property_id = request('propertyId');
        $record->association_email = request('email');                
        $record->template = request('template');                            
        $record->language = 'NL';                            

        $status = $record->save(); 

        return [
            'status' => $status,
            'data' => [
                'id' => $record->id,
            ]
        ];

    }
}
