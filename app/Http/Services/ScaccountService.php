<?php
/**
 * Created by PhpStorm.
 * User: cos
 * Date: 03/12/15
 * Time: 13:57
 */

namespace App\Http\Services;


use App\Models\PropertyCharge;
use App\Models\ServiceCostAccount;
use App\Models\DataProperty;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScaccountService
{
    protected $request;
    protected $userService;

    public function __construct(\Illuminate\Http\Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    /**
     * @return array
     */
    public function save()
    {
        $scaccount = new ServiceCostAccount();
        $files = $this->request->get('files', null);
        $scaccount->property_id = $this->request->get('property_id', null);    
        $scaccount->year = $this->request->get('year');
        $scaccount->amountPP = $this->request->get('amount');
        $scaccount->costID = $this->request->get('costID');

        $data = $this->request->all();
        $fileName = $this->uploadBaseFile($data);
        $scaccount->jpgFile = $fileName;
        $status = $scaccount->save();
//        if ($files && is_array($files)) {
//            $scaccount->jpgFile = $files[0]['file'];
//        }

        return [
            'status' => $status            
        ];

    }

    public function uploadBaseFile($data){
        $property = $data['property_id'];
        if ($property) {
            $relativePath = $this->userService->getRelativePath() . '/properties/' . $property . '/scaccount/';
        } else {
            $relativePath = $this->userService->getRelativePath() . '/scaccount/';
        }
        $directory = public_path() . $relativePath;
        $file = $data['image'];
        $img = str_replace('data:image/png;base64,', '', $file);
        $imageData = base64_decode($img);
        $fileName =uniqid() . '.png';
        $realFileName=  $relativePath . $fileName;
        $uploadFileName = $directory . $fileName;
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        file_put_contents($uploadFileName, $imageData);

        return $realFileName;
    }
    public function getScaccounts($params = [])
    {
        $scaccounts = ServiceCostAccount::where('property_id', (int)$params['property_id']);                        
             
        return $scaccounts->get();
    }

    public function getCostTypes($params = [])
    {
        $properties = DataProperty::where('type', 'SCtype')->get();
        $types = array();                        
        foreach ($properties as $property) {
            $type = new \stdClass();
            $type->id = $property->id;
            $type->name = $property->property_name->name;            
            array_push($types, $type);
        }        
        return $types;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $scaccount = ServiceCostAccount::where('id', $id)->first();
        if ($scaccount) {
            $remove = $scaccount->delete();
            if ($remove) {
                return [
                    'status' => 1
                ];
            }
        }
        return [
            'status' => 0
        ];
    }

    /**
     * @return array
     */
    public function uploadFile()
    {
        $filename = $this->request->file('file')->getClientOriginalName();
        $property = (int)$this->request->get('property_id');
        if ($property) {
            $relativePath = $this->userService->getRelativePath() . '/properties/' . $property . '/scaccount/';
        } else {
            $relativePath = $this->userService->getRelativePath() . '/scaccount/';
        }
        $directory = public_path() . $relativePath;
        $fileSize = $this->request->file('file')->getSize();
        $upload_success = $this->request->file('file')->move($directory, $filename);
        if ($upload_success) {
            $file = [
                'file' => $relativePath . $filename,
                'id' => $property . $filename,              // this is indispensable field                 
                'file_size' => $fileSize,
            ];
            return [
                'status' => 1,
                'file' => $file
            ];
        }
      
    //     return [
    //         'status' => 0,
    //         'file' => null
    //     ];
    // }

	}
}