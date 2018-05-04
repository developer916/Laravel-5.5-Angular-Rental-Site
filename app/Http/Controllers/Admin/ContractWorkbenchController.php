<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

use App\Models\Rent;
use App\Models\RentComponent;
use Illuminate\Http\Request;
use App\Models\Property;
use DB;
use Auth;
use App\User;
class ContractWorkbenchController extends AdminController {

    function __construct() {
        parent::__construct();
    }

    public  function getRentComponents() {
        $data = [];
        $rentComponents = '';

        $landlord =0;
        $lang = \App::getLocale();
        $sql = "SELECT * FROM `data_properties` INNER JOIN data_property_names on data_properties.id = data_property_names.data_property_id where data_properties.type= 'RentComponent' and data_property_names.language_code='".$lang."'";
        $dataProperties = DB::select($sql);
        $user = Auth::user();
        $properties = Property::where('user_id', $user->id)->whereNull('parent_id')->where('address', '!=', '')->get();
        $roles = $this->getRoles();
        // $sql_all_rent = "SELECT rent_components.*, properties.parent_id, properties.address, properties.title, data_property_names.name FROM `rent_components` INNER join properties on properties.id = rent_components.property_id INNER join data_property_names on data_property_names.data_property_id = rent_components.data_property WHERE data_property in (select id from data_properties where type='RentComponent') and rent_components.property_id != ''  and data_property_names.language_code='".$lang."'";
        $sql_all_rent = "SELECT rent_components.*,
                               properties.parent_id,
                               properties.address,
                               properties.title,
                               data_property_names.name
                        FROM   `rent_components`
                       LEFT OUTER JOIN properties
                               ON properties.id = rent_components.property_id
                       LEFT OUTER JOIN data_property_names
                               ON data_property_names.data_property_id =
                               (SELECT id
                                         FROM   data_properties
                                         WHERE  type = 'RentComponent' 
                                            AND data_properties.value=rent_components.data_property
                                            AND rent_components.property_id != ''
                                            AND data_property_names.language_code = '".$lang."') 
                                            where rent_components.user_id=".$user->id;
        $users = array();
        $users = User::select('id', 'name')->where('parent_id' , '0')->get();

        $rentComponents = DB::select($sql_all_rent);
        if(count($rentComponents) >0) {
            foreach($rentComponents as $rentComponent) {
                $rentComponent->unit = '';
//                $rentComponent->actions = '<a onclick="return confirm(\'' . trans('actions.delete_rent_component') . '\')" class="btn-delete btn btn-xs btn-circle red  hidden-md hidden-sm hidden-xs" href="contractWorkbench/deleteRentComponent/' . $rentComponent->id . '"><i class="fa fa-pencil"></i>' . trans('actions.delete') . '</span></a>';
                $rentComponent->actions = '<a class="btn-delete btn btn-xs btn-circle red  hidden-md hidden-sm hidden-xs"><i class="fa fa-pencil"></i>' . trans('actions.delete') . '</span></a>';
                $rentComponent->propertyTitle = $rentComponent->address;
                if($rentComponent->propertyTitle=='')
                {
                    $rentComponent->propertyTitle="FOR ALL PROPERTIES";
                }
                if($rentComponent->parent_id !=NULL){
                    $rentComponent->unit = $rentComponent->title;
                }
            }
        }



        $data = [
            'selectRentComponents'  => $dataProperties,
            'rentComponents'        => $rentComponents,
            'properties'            => $properties,
            'landlord'              => $landlord,
            'users'                 => $users
        ];
        return response()->json($data);

    }
    public function getPropertyUnits($propertyID){
        $properties = Property::where('parent_id', $propertyID)->get();
        return response()->json($properties);
    }

    public function getRoles() {
        $user = Auth::user();
        $roles = is_null($user->role())? [] : $user->role()->pluck('slug')->toArray();
        return $roles;
    }

    public function postCreateRentComponent(Request $request){
        $data_property = $request->get('data_property');
        $property_id = $request->get('property_id');
        $unit_id = $request->get('unit_id');
        $effective_date = $request->get('effective_date');
        $amount = $request->get('amount');
        $roles = $this->getRoles();
        $rentComponent = new RentComponent();
        if($unit_id !='') {
            $rentComponent->property_id = $unit_id;
        }else{
            $rentComponent->property_id = $property_id;
        }


        if (in_array('landlord', $roles)) {
            $rentComponent->user_id = Auth::user()->id;
        }
        $rentComponent->data_property = $data_property;

        $rentComponent->effective_date = $effective_date;
        $rentComponent->value= $amount;
        $rentComponent->save();
        return response()->json(['status' => 0]);
    }

    public function deleteRentComponent($rentComponentID){
        $rentComponent = RentComponent::findOrFail($rentComponentID);
        $roles = $this->getRoles();
        if (in_array('administrator', $roles) || in_array('manager', $roles)) {
            $rentComponent->delete();
        }else if(in_array('landlord', $roles) && $rentComponent->user_id = Auth::user()->id){
            $rentComponent->delete();
        }
      return response()->json(['status' => 0]);
    }


}