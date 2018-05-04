<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\PropertyRequest;
use App\Http\Services\DocumentService;
use App\Http\Services\PropertyService;
use App\Http\Services\TransactionService;
use App\Http\Services\ScaccountService;
//use App\Language;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Property;

use App\Models\Profile;
use App\Models\PropertyTenant;

use App\Models\PropertyMonthlyExpense;

use App\Models\PropertyType;
use App\Models\PropertyTransaction;
use Auth;
use Mockery\Exception;

class PropertyController extends AdminController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */

    public function getProperties()
    {
        $count = Property::where('user_id', Auth::user()->id)->where('status', 1)->count();
        $profile = Profile::where('user_id', Auth::user()->id)->with('currency')->first();
        $currency = '&euro;';
        if ($profile && $profile->currency) {
            $currency = $profile->currency->html;
        }
        $properties = Property::where('user_id', Auth::user()->id)->where('status', 1)->whereNull('parent_id')->get([
            'id',
            'created_at',
            'created_at',
            'title',
            'street_no',
            'status',
            'address',
            'city',
            'slug'
        ]);

        foreach ($properties as $property) {
            /*--TODO: handle currencies */

//            $propertyTransaction = PropertyTransaction::where('property_id',
//                $property->id)->where('transaction_category_id',
//                1)->whereNull('property_transactions.user_id')->first();
//
//            if ($propertyTransaction) {
//                $property->rental_price = $currency . number_format($propertyTransaction->amount) . '<sup>' . ((isset($propertyTransaction->amount_tax) && $propertyTransaction->amount_tax != 0) ? '+' . $propertyTransaction->amount_tax . '%' : '') . '</sup>';
//            } else {
//                $property->rental_price = '0 ' . $currency;
//            }
            $totalAmount = 0;
            $propertyTransactions = \DB::select("select user_id from property_transactions where property_transactions.effective_date <= now() and property_transactions.transaction_category_id = 1 and property_transactions.user_id is not null and property_transactions.property_id=".$property->id." group by user_id");
            if(count($propertyTransactions) > 0 ){
                foreach($propertyTransactions as $key => $propertyTransactionUser) {
                    if($propertyTransactionUser->user_id){
                        $propertyTotalAmountSelects = \DB::select("SELECT property_transactions.property_id, property_transactions.user_id, property_transactions.amount_total, property_transactions.unit_id, property_transactions.effective_date FROM property_transactions left join property_tenants on property_tenants.unit_id = property_transactions.unit_id where property_transactions.property_id = ".$property->id." and property_tenants.user_id= property_transactions.user_id and property_transactions.effective_date <= now() and property_transactions.user_id=".$propertyTransactionUser->user_id. " Order by property_transactions.effective_date desc");
                        if(count($propertyTotalAmountSelects) >0) {
                            $totalAmount += $propertyTotalAmountSelects[0]->amount_total;
                        }
                    }
                }
                $property->rental_price = $currency . number_format($totalAmount, 2);
            }else {
                $property->rental_price = '0 ' . $currency;
            }
            $property->tenant = '';
            $propertyTenants = PropertyTenant::where('property_id', $property->id)->get();
            $isRented = false;
            foreach ($propertyTenants as $propertyTenant) {
                $profile = Profile::where('user_id', $propertyTenant->user_id)->first();
                if ($profile) {
                    $property->tenant .= '<a href="javascript:;"><img width="35" src="' . $profile->avatar . '" /></a>';
                } else {
                    $isRented = true;
                }
            }

            if (!$property->tenant && $isRented === false) {
                $property->tenant = '<span class="label label-sm label-danger">Not rented</span>';
            } elseif ($isRented === true) {
                $tenantsCount = PropertyTenant::where('property_id', $property->id)->count();
                $property->tenant = '<span class="label label-sm label-success">' . $tenantsCount . ' ' . (($tenantsCount > 1) ? trans('admin.tenants') : trans('admin.tenant')) . '</span>';
            }

            $property->actions = propertyActions($property->id);
            if ($property->photos->first()['file']) {
                $property->photo = '<img src="' . $property->photos->first()['file'] . '" width="75" />';
            } else {
                $property->photo = '<img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/property_placeholder.png" width="75" />';
            }
            if ($property->status == 0 || (int)$property->slug < 0) {
                $property->status = '<a href="javascript:;" class="btn danger btn-danger btn-xs">' . trans('actions.draft') . '</a>';
            }
            if ($property->status == 1) {
                $property->status = '<a href="javascript:;" class="btn default green-stripe btn-xs">' . trans('actions.active') . '</a>';
            }
            if ($property->status == 2) {
                $property->status = '<a href="javascript:;" class="btn default red-stripe btn-xs">' . trans('actions.rented') . '</a>';
            }
        }

        return response()->json([
            'data' => $properties,
            'recordsFiltered' => $count,
            'draw' => 2,
            'recordsTotal' => $count
        ]);
    }

    public function getDocuments(DocumentService $documentService, $propertyId)
    {
        $documents = $documentService->getAuthUserDocuments(['property_id' => $propertyId]);
        $arrDocs = [];
        foreach ($documents as $document) {
            if ($document->file) {
                $arrDocs[] = [
                    'id' => $document->id,
                    'file' => '<a href="' . $document->file . '">' . $document->file . '</a>',
                    'description' => $document->description,
                    'privacy' => $document->privacy,
                    'date' => $document->created_at->diffForHumans(),
                    'size' => bytesToSize($document->file_size),
                    'actions' => ''
                ];
            }
        }
        $cnt = count($arrDocs);
        return response()->json([
            'data' => $arrDocs,
            'recordsFiltered' => $cnt,
            'draw' => 2,
            'recordsTotal' => $cnt
        ]);
    }

    public function getProperty(PropertyService $service, $id)
    {
        return response()->json($service->read($id));
    }

    public function getPropertyOverview(PropertyService $service, $id)
    {

        return response()->json($service->getOverview($id));
    }

    public function getBasic(PropertyService $service, $id)
    {
        return response()->json($service->view($id));
    }

    public function getUnits(PropertyService $service, $id)
    {
        return response()->json($service->getUnits($id));
    }

    public function getIdentity($id)
    {
        return response()->json(Property::where('id', $id)->with([
            'photos' => function ($query) {
                $query->where('is_main', 1);
            },
        ])->get(['id', 'title', 'status', 'address', 'is_pro', 'is_autoshare', 'parent_id'])->first());
    }

    public function getCountTransactions($id)
    {
        $count = 0;
        if (Property::where('id', $id)->where('user_id', Auth::user()->id)->exists()) {
            $count = PropertyTransaction::where('property_id', $id)->whereNull('user_id')->count();
        }
        return response()->json([
            'count' => $count
        ]);
    }

    public function getTransactions(TransactionService $service, $id)
    {
        if (Property::where('id', $id)->where('user_id', Auth::user()->id)->exists()) {
            $data = $service->getPropertyTransaction($id)['data'];
            return response()->json([
                'data' => $data,
                'status' => 1,
                'recordsFiltered' => count($data),
                'draw' => 2,
                'recordsTotal' => count($data)
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'data' => []
            ]);
        }
    }


    public function getCurrencies()
    {
        return response()->json(Currency::pluck('title', 'id'));
    }

    public function getCountries()
    {
        return response()->json(Country::get());
    }

    public function getPropertyTypes()
    {
        return response()->json(PropertyType::pluck('title', 'id'));
    }

    public function getTransactionCategories(TransactionService $service)
    {
        return response()->json(
            ['data'=>$service->getTransactionCategories()['data']]
        );
    }

    public function getTransactionTypes(TransactionService $service)
    {
        return response()->json(
            ['data'=>$service->getTransactionTypes()['data']->pluck('title', 'id')]
        );
    }

    public function getTransactionRecurrings(TransactionService $transactionService)
    {
        return response()->json(
            ['data'=>$transactionService->getTransactionRecurrings()['data']->pluck('title', 'id')]
        );
    }

    public function getDeleteTransactions(TransactionService $service, $id)
    {
        return response()->json($service->deleteTransaction($id));
    }

    public function postTransaction(TransactionService $transactionService)
    {
        return response()->json($transactionService->saveTransaction());
    }

    /**
     * Saves in json format the social media profile of the property
     */
    public function postUpdateMedia(PropertyService $service)
    {
        return response()->json($service->saveMedia());
    }

    /**
     * @param PropertyRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreate(PropertyService $service)
    {

        return response()->json($service->save());
    }

    /**
     * @param PropertyRequest $request
     */
    public function postUpdate(PropertyService $service)
    {
        return response()->json($service->save());
    }

    public function postEdit(PropertyRequest $request)
    {
        return response()->json(Property::with('photos', 'documents',
            'tenants.tenant')->find($request->id)->toArray());
    }


    /**
     * @param PropertyRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUploadPhotos(PropertyService $service)
    {
        $result = $service->uploadMainPhoto();
        if ($result['status']) {
            return response()->json($result['file'], 200);
        } else {
            return response()->json([], 400);
        }
    }

    /**
     * Uses laravel soft delete
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDeleteProperty(PropertyService $service, $id)
    {
        $delete = $service->delete($id);
        return redirect('/dashboard#/properties');
        //return response()->json($service->delete($id));
    }

    /**
     * Uses laravel soft delete
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDeletePhoto(PropertyService $service, $propertyId, $id)
    {
        return response()->json($service->deletePhoto($propertyId, $id));
    }


    public function postUploadDocuments(DocumentService $service)
    {
        $result = $service->uploadFile();
        if ($result['status']) {
            return response()->json($result['file'], 200);
        } else {
            return response()->json([], 400);
        }
    }

    public function getAmenities(PropertyService $service)
    {
        return response()->json($service->getAllAmenities());
    }

    // Service Cost Account
    public function getScacounts(ScaccountService $scacountService, $propertyId)
    {
        $scacounts = $scacountService->getScaccounts(['property_id' => $propertyId]);
        $arrDocs = [];

        foreach ($scacounts as $scacount) {                                    
            $arrDocs[] = [
                'id' => $scacount->id,                    
                'sca_type' => $scacount->sca_type->name,
                'year' => $scacount->year,
                'amount' => $scacount->amountPP,                    
                'file' => '<a href="' . $scacount->jpgFile . '" target="_blank">' . $scacount->jpgFile . '</a>',
                'actions' => ''
            ];
            
        }
        $cnt = count($arrDocs);                
        return response()->json([
            'data' => $arrDocs,
            'recordsFiltered' => $cnt,
            'draw' => 2,
            'recordsTotal' => $cnt
        ]);
    }

    public function getCostTypes(ScaccountService $scacountService, $baseType)
    {
        if($baseType = "SCtype") {
            $types = $scacountService->getCostTypes();                                                    
            
            return response()->json($types);
        }
        
    }
    
    // public function postScaccountUpload(ScaccountService $service)
    // {
    //     $result = $service->uploadFile();
    //     if ($result['status']) {
    //         return response()->json($result['file'], 200);
    //     } else {
    //         return response()->json([], 400);
    //     }
    // }
    
    public function postCreateScacount(ScaccountService $service)
    {
        return response()->json($service->save());
    }

    public function getDeleteScaccount(ScaccountService $service, $id)
    {
        return response()->json($service->delete($id));
    }

    //////////////////
}

