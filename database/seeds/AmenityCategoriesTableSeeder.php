<?php

use Illuminate\Database\Seeder;

class AmenityCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AmenityCategory::create([
            'title' => 'Building',
        ]);
        \App\Models\AmenityCategory::create([
            'title' => 'Facilities',
        ]);
        \App\Models\AmenityCategory::create([
            'title' => 'Accesibility',
        ]);
        \App\Models\AmenityCategory::create([
            'title' => 'Property',
        ]);
        \App\Models\AmenityCategory::create([
            'title' => 'Furnishing',
        ]);
        \App\Models\AmenityCategory::create([
            'title' => 'Utilities Included',
        ]);
        \App\Models\AmenityCategory::create([
            'title' => 'Extras',
        ]);
    }
}
