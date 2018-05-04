<?php

use Illuminate\Database\Seeder;

class ContractTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\ContractType::create([
            'title' => 'Rentling default',
        ]);
        \App\Models\ContractType::create([
            'title' => 'Landlord',
        ]);
        \App\Models\ContractType::create([
            'title' => 'Property',
        ]);
        \App\Models\ContractType::create([
            'title' => 'Unit',
        ]);
    }
}
