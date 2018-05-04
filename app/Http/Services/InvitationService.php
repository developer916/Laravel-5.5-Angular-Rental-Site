<?php

namespace App\Http\Services;

use App\Mail\landlordInvitation;
use App\Models\Country;
use App\Models\Property;
use App\Models\PropertyTenant;
use App\User;

class InvitationService
{

    private static $unitNameList = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'
    ];

    public function save($data)
    {
        $user = User::findOrFail($data['user_id']);

        $user->revokeRole('Guest');

        if ($data['role'] === 'landlord') {
            $this->createLandlord($data, $user);

        } else if ($data['role'] === 'tenant') {
            $this->createTenant($data, $user);
        }
    }

    private function createLandlord($data, User $user)
    {
        $user->assignRole('landlord');

        foreach ($data['tenants'] as $rowTenant) {
            $tenant = $this->getTenant($rowTenant['email']);
            if (!$tenant) {
                $tenant = $this->inviteTenant($rowTenant['email'], $rowTenant['name']);
            }

            $property = $this->getProperty($rowTenant['post_code'], $rowTenant['street_no'], $user);

            if (!$property) {
                $property = $this->createProperty($rowTenant['post_code'], $rowTenant['street_no'], $user);
            } elseif (!$this->isPropertyWithTenantExists($property, $tenant)) {
                $property = $this->createPropertyUnits($property, $user, $tenant);
            }

            $this->connectTenantAndProperty($property, $tenant, $rowTenant['start_date']);
        }
    }

    private function createTenant($data, User $tenant)
    {
        $tenant->assignRole('tenant');

        $newLandlord = null;
        $landlord = $this->getLandlord($data['landlord']['email']);
        if (!$landlord) {
            $landlord = $this->inviteLandlord($data['landlord']['email'], $data['landlord']['name']);
            $newLandlord = true;
        }

        $property = $this->getProperty($data['address']['post_code'], null, $landlord);
        if (!$property) {
            $property = $this->createProperty($data['address']['post_code'], null, $landlord);
        } elseif (!$this->isPropertyWithTenantExists($property, $tenant)) {
            $property = $this->createPropertyUnits($property, $landlord, $tenant);
        }

        $this->connectTenantAndProperty($property, $tenant, $data['start_date']);

        if ($newLandlord) {
            $url = route('register');
            \Mail::to($landlord->email)->send(new landlordInvitation($url, $tenant, $landlord->name, $property));
        }
    }

    private function isPropertyWithTenantExists($property, User $tenant)
    {
        return PropertyTenant::where('property_id', $property->id)->where('user_id', $tenant->id)->exists();
    }

    private function getTenant($email)
    {
        return User::whereEmail($email)->first();
    }

    // TODO fix activation process for tenant
    private function inviteTenant($email, $name)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt(str_random(10)),
            'confirmation_code' => ''
        ]);
        // stupid eloquent
        $user = User::where('email', $email)->first();

        $user->assignRole('tenant');

        return $user;
        // TODO send invitation email
    }

    private function isTenantConnectedToProperty(Property $property, User $tenant)
    {
        return PropertyTenant::where('property_id', $property->id)
            ->where('user_id', $tenant->id)->exists();
    }

    private function connectTenantAndProperty(Property $property, User $tenant, $startDate)
    {
        if (!$this->isTenantConnectedToProperty($property, $tenant)) {
            $propertyId = null;
            $unitId = null;
            // room
            if ($property->property_type_id === 1) {
                $propertyId = $property->parent_id;
                $unitId = $property->id;
            } else {
                $propertyId = $property->id;
            }

            PropertyTenant::create([
                'property_id' => $propertyId,
                'user_id' => $tenant->id,
                'unit_id' => $unitId,
                'collection_day' => 1,
                'start_date' => date("Y-m-d H:i:s", strtotime($startDate))
            ]);
        }
    }

    private function getLandlord($email)
    {
        return User::whereEmail($email)->first();
    }

    // TODO fix activation process for landlord
    private function inviteLandlord($email, $name)
    {
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt(str_random(10)),
            'confirmation_code' => ''
        ]);
        // stupid eloquent
        $user = User::where('email', $email)->first();

        $user->assignRole('landlord');

        return $user;
    }


    private function getProperty($postCode, $streetNo = null, User $user)
    {
        return $user->properties()->where('post_code', $postCode)
            ->when($streetNo, function ($query) use ($streetNo) {
                return $query->where('street_no', $streetNo);
            })
            ->first();
    }

    private function createPropertyUnits(Property $property, User $user, User $tenant)
    {
        // no sub properties
        if (Property::where('parent_id', $property->id)->count() === 0) {
            $newUnit = $this->createProperty($property->post_code, $property->street_no, $user, $property->id, 'A');

            //transfer existing tenant to new unit
            $propertyTenant = PropertyTenant::where('property_id', $property->id)->first();
            $propertyTenant->unit_id = $newUnit->id;
            $propertyTenant->save();
        }

        $unitsCount = Property::where('parent_id', $property->id)->count();

        return $this->createProperty($property->post_code, $property->street_no, $user, $property->id, self::$unitNameList[$unitsCount]);
    }

    private function createProperty($zipCode, $street_no = null, User $user, $parentPropertyID = null, $unitID = null)
    {
        $data = $this->getAddressDataFromZipcode($zipCode, $street_no);

        if ($parentPropertyID !== null && $unitID != "") {
            $data['parent_id'] = $parentPropertyID;
            $data['title'] = "Kamer " . $unitID;
            $data['property_type_id'] = 1;
        } else {
            $data['property_type_id'] = 2;
        }
        $data['plan'] = 'free';
        $data['is_pro'] = 0;
        $data['is_autoshare'] = 0;
        $data['status'] = 1;
        $data['user_id'] = $user->id;
        $data['description'] = '';

        return Property::create($data);
    }

    private function getAddressDataFromZipcode($zipCode, $street_no = null)
    {
        $data = [
            'country_id' => 1,
            'street_no' => is_null($street_no) ? '' : $street_no,
            'street' => '',
            'city' => '',
            'state' => '',
            'post_code' => $zipCode,
            'lng' => 0,
            'lat' => 0,
            'title' => '',
            'address' => ''
        ];

        $results = app('geocoder')->geocode($zipCode)->get();

        if ($results->count()) {
            $result = $results->first();
            $country = Country::where('title', $result->getCountry()->getName())->where('status', '1')->first();

            if ($country) {
                $data['country_id'] = $country->id;
            }

            $data['lng'] = $result->getCoordinates()->getLongitude();
            $data['lat'] = $result->getCoordinates()->getLatitude();
            $data['city'] = $result->getLocality();
            $data['state'] = $result->getAdminLevels()->first()->getCode();
            $data['address'] = $result->getFormattedAddress();
        }

        $data['title'] = $this->createPropertyTitle($data);

        return $data;
    }

    // should be mutator on Property model
    private function createPropertyTitle($data)
    {
        $title = '';
        if (!empty($data['street'])) {
            $title .= $data['street'] . ' ';
        }
        if (!empty($data['street_no'])) {
            $title .= $data['street_no'] . ' ';
        }
        if (!empty($data['post_code'])) {
            $title .= $data['post_code'] . ' ';
        }
        if (!empty($data['city'])) {
            $title .= ' (' . $data['city'] . ' )';
        }

        return $title;
    }
}