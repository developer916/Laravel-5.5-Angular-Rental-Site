<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();

        \App\Models\Country::create([
            'title' => 'Netherlands',
        ]);
        \App\Models\Country::create([
            'title' => 'Germany',
        ]);
        \App\Models\Country::create([
            'title' => 'United Kingdom',
        ]);

    }
}
