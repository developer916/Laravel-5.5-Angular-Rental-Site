<?php

use Illuminate\Database\Seeder;
use App\Models\FreeFunction;

class FreeFunctionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FreeFunction::truncate();

//        FreeFunction::create([
//            'start_month'  => 4,
//            'start_day'    => 1,
//            'end_month'    => 5,
//            'end_day'      => 1,
//            'menu_item_id' => '/#contract-templates'
//        ]);

        FreeFunction::create([
            'start_month'  => 4,
            'start_day'    => 1,
            'end_month'    => 5,
            'end_day'      => 1,
            'menu_item_id' => '#/send-rent-increase'
        ]);

        FreeFunction::create([
            'start_month'  => 4,
            'start_day'    => 1,
            'end_month'    => 5,
            'end_day'      => 1,
            'menu_item_id' => '#/contract-workbench'
        ]);

        FreeFunction::create([
            'start_month'  => 6,
            'start_day'    => 1,
            'end_month'    => 7,
            'end_day'      => 1,
            'menu_item_id' => '#/send-rent-increase'
        ]);

        FreeFunction::create([
            'start_month'  => 6,
            'start_day'    => 1,
            'end_month'    => 10,
            'end_day'      => 1,
            'menu_item_id' => '#/contract-workbench'
        ]);

//        FreeFunction::create([
//            'start_month'  => 5,
//            'start_day'    => 1,
//            'end_month'    => 6,
//            'end_day'      => 1,
//            'menu_item_id' => '/#SC-accounts'
//        ]);

//        FreeFunction::create([
//            'start_month'  => 6,
//            'start_day'    => 1,
//            'end_month'    => 7,
//            'end_day'      => 1,
//            'menu_item_id' => '/#credits-charges'
//        ]);

        FreeFunction::create([
            'start_month'  => 6,
            'start_day'    => 1,
            'end_month'    => 7,
            'end_day'      => 1,
            'menu_item_id' => '#/payment-per-tenant'
        ]);

        FreeFunction::create([
            'start_month'  => 7,
            'start_day'    => 1,
            'end_month'    => 8,
            'end_day'      => 1,
            'menu_item_id' => '#/payment-per-tenant'
        ]);

        FreeFunction::create([
            'start_month'  => 11,
            'start_day'    => 1,
            'end_month'    => 12,
            'end_day'      => 1,
            'menu_item_id' => '#/contract-workbench'
        ]);

        FreeFunction::create([
            'start_month'  => 7,
            'start_day'    => 1,
            'end_month'    => 8,
            'end_day'      => 1,
            'menu_item_id' => '#/contract/template'
        ]);
//
        FreeFunction::create([
            'start_month'  => 10,
            'start_day'    => 1,
            'end_month'    => 11,
            'end_day'      => 1,
            'menu_item_id' => '#/contract/association'
        ]);
//
//        FreeFunction::create([
//            'start_month'  => 2,
//            'start_day'    => 1,
//            'end_month'    => 4,
//            'end_day'      => 1,
//            'menu_item_id' => '/#association-square'
//        ]);
//
//        FreeFunction::create([
//            'start_month'  => 2,
//            'start_day'    => 1,
//            'end_month'    => 4,
//            'end_day'      => 1,
//            'menu_item_id' => '/#heat-back-charges'
//        ]);
    }
}
