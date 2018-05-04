<?php

use Illuminate\Database\Seeder;

class PropertyTenantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PropertyTenant::create([
            'property_id' => 2,
            'collection_day' => 15,
            'created_at'=>'2015-09-20 14:00:00',
            'user_id' => 4,
        ]);
    }
}
