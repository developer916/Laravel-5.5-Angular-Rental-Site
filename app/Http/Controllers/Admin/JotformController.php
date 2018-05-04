<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\InvitationService;
use App\User;
use Illuminate\Http\Request;

class JotformController extends Controller
{
    public function webhook(Request $request, InvitationService $invitationService)
    {
        $invitationService->save($this->parseWebhookData($request->all()));

        return [];
    }

    private function parseWebhookData($data)
    {
        $rawRequest = json_decode($data['rawRequest']);

        User::findOrFail($rawRequest->q38_user_id);

        $params = ['user_id' => $rawRequest->q38_user_id];
        if ($rawRequest->q33_RentlingUsage === 'Als verhuurder') {
            $params['role'] = 'landlord';
            $params['tenants'] = [];

            foreach (json_decode($rawRequest->q34_verhuurdeLocaties) as $tenant) {
                $tenant = get_object_vars($tenant);
                $params['tenants'][] = [
                    'post_code' => $tenant['Postcode'],
                    'street_no' => $tenant['Huisnr'],
                    'email' => $tenant['Email huurder'],
                    'name' => $tenant['Naam huurder'],
                    'start_date' => $tenant['Startdatum verhuur'],
                ];
            }

        } else {
            $params['role'] = 'tenant';

            $params['landlord'] = [
                'name' => $rawRequest->q35_rentlingForTenants->field_1,
                'email' => $rawRequest->q35_rentlingForTenants->field_2
            ];

            $params['start_date'] = $rawRequest->q35_rentlingForTenants->field_3;

            $address = $rawRequest->q40_addressWaar;
            $params['address'] = [
                "street" =>  $address->addr_line1,
                "city" =>  $address->city,
                "state" =>  $address->state,
                "post_code" =>  $address->postal,
                "country" =>  $address->country,
            ];
        }

        return $params;
    }

}