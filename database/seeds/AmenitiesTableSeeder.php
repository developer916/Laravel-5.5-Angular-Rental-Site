<?php

use Illuminate\Database\Seeder;

class AmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Amenity::create([
            'title' => 'Construction year',
            'amenity_category_id' => 1,
            'type' => 'INT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Floors',
            'amenity_category_id' => 1,
            'type' => 'INT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Energy label',
            'amenity_category_id' => 1,
            'type' => 'VARCHAR'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Video surveillance',
            'amenity_category_id' => 1,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Gym',
            'amenity_category_id' => 2,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Parking',
            'amenity_category_id' => 2,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Garage',
            'amenity_category_id' => 2,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Garden',
            'amenity_category_id' => 2,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Disability ramps',
            'amenity_category_id' => 3,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Elevator',
            'amenity_category_id' => 3,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Bathroom',
            'amenity_category_id' => 4,
            'type' => 'INT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Toilet',
            'amenity_category_id' => 4,
            'type' => 'INT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Balcony',
            'amenity_category_id' => 4,
            'type' => 'INT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Terrace',
            'amenity_category_id' => 4,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Basement',
            'amenity_category_id' => 4,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Dishwasher',
            'amenity_category_id' => 4,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Washing machine',
            'amenity_category_id' => 4,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Dryer',
            'amenity_category_id' => 4,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Fridge',
            'amenity_category_id' => 4,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Wifi',
            'amenity_category_id' => 4,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Furnished',
            'amenity_category_id' => 5,
            'type' => 'VARCHAR'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Double-glaze windows',
            'amenity_category_id' => 5,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Bed',
            'amenity_category_id' => 5,
            'type' => 'INT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Desk',
            'amenity_category_id' => 5,
            'type' => 'INT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Closet',
            'amenity_category_id' => 5,
            'type' => 'INT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'TV',
            'amenity_category_id' => 5,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Gas',
            'amenity_category_id' => 6,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Water',
            'amenity_category_id' => 6,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Electricity',
            'amenity_category_id' => 6,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Internet',
            'amenity_category_id' => 6,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Registration',
            'amenity_category_id' => 7,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Smoking',
            'amenity_category_id' => 7,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Pets',
            'amenity_category_id' => 7,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Events',
            'amenity_category_id' => 7,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Meeting room',
            'amenity_category_id' => 2,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Kitchen',
            'amenity_category_id' => 2,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Phone',
            'amenity_category_id' => 2,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Lunch facilities',
            'amenity_category_id' => 2,
            'type' => 'TINYINT'
        ]);
        \App\Models\Amenity::create([
            'title' => 'Reception',
            'amenity_category_id' => 2,
            'type' => 'TINYINT'
        ]);
    }
}
