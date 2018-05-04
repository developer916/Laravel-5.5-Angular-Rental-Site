<?php

use Illuminate\Database\Seeder;

class PropertyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\PropertyType::create([
            'title' => 'Room',
        ]);
        \App\Models\PropertyType::create([
            'title' => 'Apartment',
        ]);
        \App\Models\PropertyType::create([
            'title' => 'House',
        ]);
        \App\Models\PropertyType::create([
            'title' => 'Commercial',
        ]);
        \App\Models\PropertyType::create([
            'title' => 'Building',
        ]);
        \App\Models\PropertyType::create([
            'title' => 'Space',
        ]);
        \App\Models\PropertyType::create([
            'title' => 'Other',
        ]);
    }
}
