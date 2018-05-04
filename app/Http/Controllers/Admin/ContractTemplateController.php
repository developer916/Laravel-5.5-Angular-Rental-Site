<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContractType;
use App\Http\Services\ContractTemplateService;

class ContractTemplateController extends Controller
{
    //
    public function getTypes()
    {
        return response()->json(ContractType::get());
    }

    public function getFormFields(ContractTemplateService $service, $typeId)
    {
        return response()->json($service->getFormFields($typeId));
    }

    public function getTemplate(ContractTemplateService $service, $typeId, $countryId, $propertyId = NULL)
    {
    	if($typeId == 1 || $typeId == 2) $propertyId = NULL;	
        return response()->json($service->view($typeId, $countryId, $propertyId));
    }

    public function postSaveTemplate(ContractTemplateService $service)
    {
        return response()->json($service->save());
    }
}
