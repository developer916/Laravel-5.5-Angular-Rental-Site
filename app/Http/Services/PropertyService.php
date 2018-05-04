<?php
namespace App\Http\Services;

use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Models\PropertyPhoto;
use App\Models\PropertyTenant;
use App\Models\PropertyTransaction;
use App\Models\PropertyTypeAmenity;
use App\Models\PropertyUserTransaction;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;


class PropertyService
{
    protected $request;
    protected $userService;

    public function __construct(\Illuminate\Http\Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    public function read($id)
    {
        $property = Property::with([
            'photos',
            'documents',
            'tenants.tenant',
            'amenities',
            'units',
            'announcements',
            'announcements.sender',
            'announcements.sender.profile'
        ])->find($id);
        return [
            'status' => ($property) ? 1 : 0,
            'data' => $property
        ];
    }

    public function view($id)
    {
        $property = Property::with([
            'photos' => function ($query) {
                $query->where('is_main', null);
            },
            'units',
            'amenities'
        ])->find($id);
        return [
            'status' => ($property) ? 1 : 0,
            'data' => $property
        ];
    }

    public function save()
    {
        $request = $this->request;
        if (!$request->get('id')) {
            $property = new Property();
            $property->title = '';
            $property->address = '';
            $property->street_no =0;
            $property->street= '';
            $property->city = '';
            $property->state = '';
            $property->post_code ='';
            $property->lng = 0;
            $property->lat = 0;

            $property->user_id = Auth::user()->id;
            if ($property->save()) {
                return [
                    'status' => 1,
                    'data' => [
                        'id' => $property->id
                    ]
                ];
            } else {
                return [
                    'status' => 0,
                ];
            }
        }
        $property = Property::find($request->get('id'));
        if ($property['parent_id']) {
            $fill = [
                'media' => $request->get('media'),
                'internal_id' => $request->get('internal_id'),
                'status' => 1,
                'title' => $request->get('title'),
            ];
        } else {
            $fill = [
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'media' => $request->get('media'),
                'internal_id' => $request->get('internal_id'),
                'property_type_id' => $request->get('property_type_id'),
                'status' => 1,
                'title' => $request->get('title'),
                'description'=>$request->get('description'),
                'country_id' => $request->get('country_id'),
                'street_no' => $request->get('street_no'),
                'post_code' => $request->get('post_code'),
                'state' => $request->has('state') ? $request->get('state') : '',
                'street' => $request->has('street') ? $request->get('street') : '',
                'is_pro' => $request->get('is_pro', 0),
                'is_autoshare' => $request->get('is_autoshare', 0),
            ];

        }
        $property->update($fill);
        //Amenities
        PropertyAmenity::where('property_id', $property->id)->delete();
        $amentiesRequest = $request->get('amenities');
        if ($amentiesRequest) {
            $amenitiesData = [];
            foreach ($amentiesRequest as $amenityId => $value) {
                if ($value) {
                    $amenitiesData[] = [
                        'property_id' => $property->id,
                        'amenity_id' => $amenityId,
                        'value' => $value
                    ];
                }
            }
            if (count($amenitiesData)) {
                \DB::table('property_amenities')->insert($amenitiesData);
            }
        }


        //Units
        $units = [];

        if (!$property['parent_id'] && $request->has('units')) {
            $units = [];
            foreach ($request->get('units') as $k => $unitRequest) {
                $unit = null;
                if (isset($unitRequest['id'])) {
                    $unit = Property::where('id', $unitRequest['id'])->first();
                    if (!$unitRequest['status']) {
                        $unit->delete();
                        continue;
                    }
                }
                if (!$unit) {
                    $unit = new Property();
                    $unit->unit = 'unit #' . ($k + 1);
                    $unit->user_id = Auth::user()->id;
                    $unit->parent_id = $property->id;
                }
                $unit->internal_id = isset($unitRequest['internal_id']) ? $unitRequest['internal_id'] : null;
                $unit->title = $unitRequest['title'];
                $unit->status = 1;
                $unit->is_pro = isset($unitRequest['is_pro']) ? $unitRequest['is_pro'] : 0;
                $unit->is_autoshare = isset($unitRequest['is_autoshare']) ? $unitRequest['is_autoshare'] : 0;
                $unit->save();
                $units[] = [
                    'id' => $unit->id,
                    'title' => $unit->title,
                    'internal_id' => $unit->internal_id,
                    'unit' => $unit->unit,
                    'is_pro' => $unit->is_pro,
                    'is_autoshare' => $unit->is_autoshare,
                    'status' => 1,
                ];
            }
        }
        return response()->json([
            'status' => 1,
            'data' => [
                'id' => $property->id,
                'units' => $units
            ]
        ]);
    }

    public function getUnits($id)
    {
        return [
            'status' => 1,
            'data' => Property::where('parent_id', $id)->get(['id', 'unit'])
        ];
    }

    public function uploadMainPhoto()
    {
        $propertyId = $this->request->get('property_id');
        $filename = $this->request->file('file')->getClientOriginalName();
        if (substr($this->request->file('file')->getMimeType(), 0, 5) == 'image') {
            $relativePath = $this->userService->getRelativePath() . '/properties/' . $propertyId . '/photos';
            $directory = public_path() . $relativePath;
        } else {
            return [
                'status' => 0
            ];
        }
        $file_size = $this->request->file('file')->getSize();
        $upload_success = $this->request->file('file')->move($directory, $filename);
        if ($upload_success) {
            if ($this->request->get('is_main')) {
                PropertyPhoto::where('property_id', $propertyId)->where('is_main', 1)->delete();
            }
            $propertyFile = PropertyPhoto::create([
                'file' => $relativePath . '/' . $filename,
                'property_id' => $propertyId,
                'file_size' => $file_size,
                'is_main' => $this->request->get('is_main'),
                'model' => 'PropertyPhoto'
            ]);
            return [
                'status' => 1,
                'file' => $propertyFile
            ];
        } else {
            return [
                'status' => 0
            ];
        }
    }

    public function saveMedia()
    {
        $data = $this->request->all();
        if (isset($data['media']) && $data['property_id']) {
            $property = Property::where('user_id', Auth::user()->id)->where('id', $data['property_id'])->first();
            $property->media = json_encode($data['media']);
            if ($property->save()) {
                return [
                    'status' => 1
                ];
            }
        }
        return [
            'status' => 0
        ];
    }


    public function getOverview($id)
    {
        $property = Property::with([
            'transactions',
            'units',
            'type',
//            'announcements.sender',
//            'announcements',
            'announcements.sender.profile',
            'tenants.tenant'
        ])->find($id);
        $overview = [];
        if ($property['units']) {
            foreach ($property['units'] as $unit) {
                $data = [
                    'id' => $unit['id'],
                    'internal_id' => $unit['internal_id'],
                    'title' => $unit['title'],
                    'unit' => $unit['unit']
                ];
                $tenants = Tenant::select(\DB::raw('users.id,users.name'))->join('property_tenants',
                    function ($join) use ($unit) {
                        $join->on('users.id', '=', 'property_tenants.user_id')
                            ->where('unit_id', '=', $unit['id']);
                    })
                    ->whereRaw('start_date <= NOW() AND end_date > NOW()')->get();
                $data['tenants'] = [];
                if ($tenants->count()) {
                    foreach ($tenants as $tenant) {
                        $tenantData = [
                            'id' => $tenant['id'],
                            'name' => $tenant['name']
                        ];
                        $userTransactions = PropertyUserTransaction::select(\DB::raw('SUM(property_user_transactions.amount) as total'))
                            ->where('property_user_transactions.user_id', $tenant['id'])
                            ->join('property_transactions', function ($join) use ($unit) {
                                $join->on('property_transactions.id', '=',
                                    'property_user_transactions.property_transaction_id')
                                    ->where('property_transactions.unit_id', '=', $unit['id']);
                            })->groupBy('property_user_transactions.user_id')->whereNotNull('property_user_transactions.amount')->first();
                        if ($userTransactions && $userTransactions->total) {
                            $tenantData['amount_total'] = $userTransactions->total;
                            $data['tenants'][] = $tenantData;
                        }
                    }
                }
                $overview[] = $data;
            }
        }
        $property['overview'] = $overview;
        return [
            'status' => 1,
            'data' => $property
        ];
    }

    public function getTenants($id)
    {

        return [
            'status' => 1,
//            'data' => \DB::table('users')
//                ->select(\DB::raw('
//                property_tenants.id,
//                name,
//                email,
//                users.id as tenant_id,
//                collection_day,
//                start_date,
//                end_date,
//                unit_id,
//                properties.unit,
//                property_id'))
//                ->leftJoin('property_tenants', function ($join) use ($id) {
//                    $join->on('users.id', '=', 'property_tenants.user_id');
//                })
//                ->leftJoin('properties', function ($join) {
//                    $join->on('properties.id', '=', 'property_tenants.unit_id');
//                })
//                ->where('users.parent_id', Auth::user()->id)
//                ->where(function ($query) use ($id) {
//                    $query->whereRaw('users.id NOT IN (SELECT user_id FROM property_tenants WHERE property_tenants.end_date > DATE(NOW()) or property_tenants.property_id="' . (int)$id . '")')
//                        ->orWhereRaw('property_tenants.id=(SELECT id from property_tenants WHERE property_id=' . $id . ' and end_date > DATE(NOW()) and user_id=users.id and deleted_at IS NULL order by end_date desc limit 1)');
//                })
//                ->groupBy('users.id')
//                ->get()
            'data' => \DB::table('users')
                ->select(\DB::raw('
                property_tenants.id,
                name,
                email,
                users.id as tenant_id,
                collection_day,
                start_date,
                end_date,
                unit_id,
                properties.unit,
                property_id'))
                ->leftJoin('property_tenants', function ($join) use ($id) {
                    $join->on('users.id', '=', 'property_tenants.user_id');
                })
                ->leftJoin('properties', function ($join) {
                    $join->on('properties.id', '=', 'property_tenants.unit_id');
                })
                ->where('users.parent_id', Auth::user()->id)
                ->where(function ($query) use ($id) {
                    $query->whereRaw('users.id  IN (SELECT user_id FROM property_tenants WHERE (property_tenants.end_date > DATE(NOW()) or property_tenants.end_date is null) and property_tenants.property_id="' . (int)$id . '")')
                        ->orWhereRaw('property_tenants.id=(SELECT id from property_tenants WHERE property_id=' . $id . ' and end_date > DATE(NOW()) and user_id=users.id and deleted_at IS NULL order by end_date desc limit 1)');
                })
                // ->groupBy('users.id')
                ->get()
        ];
    }


    public function delete($id)
    {
        $result = Property::where('user_id', Auth::user()->id)->where('id', $id)->first()->delete();
        if ($result) {
            return ['status' => 1];
        }
        return ['status' => 0];
    }

    public function deletePhoto($propertyId, $id)
    {
        if (Property::where('user_id', Auth::user()->id)->where('id', $propertyId)->exists()) {
            $result = PropertyPhoto::where('property_id', $propertyId)->where('id',
                $id)->first()->delete();
            if ($result) {
                return ['status' => 1];
            }
        }
        return ['status' => 0];
    }


    public function getAllAmenities()
    {
        $propertyTypeAmenities = PropertyTypeAmenity::with('amenity.category')->get();
        $data = [];
        foreach ($propertyTypeAmenities as $propertyTypeAmenity) {
            if (!isset($data[$propertyTypeAmenity['property_type_id']])) {
                $data[$propertyTypeAmenity['property_type_id']] = [];
            }
            if (!isset($data[$propertyTypeAmenity['property_type_id']][$propertyTypeAmenity['amenity']['category']['id']])) {
                $data[$propertyTypeAmenity['property_type_id']][$propertyTypeAmenity['amenity']['category']['id']] = [
                    'id' => $propertyTypeAmenity['amenity']['category']['id'],
                    'title' => $propertyTypeAmenity['amenity']['category']['title'],
                    'amenities' => []
                ];
            }
            $data[$propertyTypeAmenity['property_type_id']][$propertyTypeAmenity['amenity']['category']['id']]['amenities'][$propertyTypeAmenity['amenity']['id']] = [
                'id' => $propertyTypeAmenity['amenity']['id'],
                'title' => $propertyTypeAmenity['amenity']['title'],
                'type' => $propertyTypeAmenity['amenity']['type'],
                'value' => $propertyTypeAmenity['amenity']['value'],
                'parent_id' => $propertyTypeAmenity['amenity']['parent_id'],
            ];
        }
        return [
            'status' => 1,
            'data' => $data
        ];
    }

    public function getAuthUserPropertiesWithCountry($country_id)
    {
        $records = Property::where('user_id', Auth::user()->id)->where('country_id', (int)$country_id);
        
        return $records->get(['id', 'title']);
    }
}
