<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->delete();
        \App\Models\Currency::create([
            'title' => 'eur',
            'symbol' => '€',
            'html'=>'&euro;',
            'weight' => 1
        ]);
        \App\Models\Currency::create([
            'title' => 'gbp',
            'symbol'=>'£',
            'html'=>'&pound;',
            'weight' => 2
        ]);
        \App\Models\Currency::create([
            'title' => 'usd',
            'symbol'=>'$',
            'html'=>'$',
            'weight' => 3
        ]);
    }
}
