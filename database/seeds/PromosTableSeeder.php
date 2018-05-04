<?php

use Illuminate\Database\Seeder;
use App\Models\Promo;

class PromosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Promo::create([
            'valid_from'    =>null,
            'valid_to'      =>null,
            'free_days'     =>90,
            'description'   =>'90 free days new user'
        ]);
        Promo::create([
            'valid_from'    =>null,
            'valid_to'      =>null,
            'free_days'     =>30,
            'code'          =>'30-Free',
            'description'   =>'30 free days extension'
        ]);
        Promo::create([
            'valid_from'    =>'2018-08-01',
            'valid_to'      =>'2018-08-30',
            'free_days'     =>15,
            'code'          =>'15-EXTEND',
            'description'   =>'15 days extension during aug promo'
        ]);
        Promo::create([
            'valid_from'    =>'2018-10-01',
            'valid_to'      =>'2018-10-31',
            'free_days'     =>21,
            'description'   =>'initial90 + 21 days extra in okt'
        ]);
        Promo::create([
            'valid_from'    =>'2018-05-01',
            'valid_to'      =>'2018-05-30',
            'free_days'     =>90,
            'code'          =>'90Free',
            'description'   =>'90 extra days with code'
        ]);
    }
}
