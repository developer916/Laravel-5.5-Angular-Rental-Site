<?php

use Illuminate\Database\Seeder;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Property::create([
            'title' => 'Apartment Rooseveltlaan in Amsterdam',
            'address' => '1078 NH Amsterdam (Noord-Holland)',
            'street_no' => '0',
            'street' => 'Rooseveltlaan',
            'city' => 'Amsterdam',
            'state' => 'Noord-Holland',
            'post_code' => '1078 NH',
            'country_id' => '1',
            'property_type_id' => '1',
            'lng' =>'0',
            'lat' =>'0',
            'user_id' => '1',
            'status'=>true,
        ]);
        \App\Models\Property::create([
            'title' => 'Apartment Tweede Helmersstraat 76 in Amsterdam ',
            'address' => '1054 CM Amsterdam (Noord-Holland)',
            'street_no' => '0',
            'street' => 'Tweede Helmersstraat',
            'city' => 'Amsterdam',
            'state' => 'Noord-Holland',
            'post_code' => '1054 CM',
            'country_id' => '1',
            'property_type_id' => '2',
            'lng' =>'0',
            'lat' =>'0',
            'user_id' => '1',
            'status'=>true,
        ]);
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
