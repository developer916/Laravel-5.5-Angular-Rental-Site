<?php

use Illuminate\Database\Seeder;

class SendRentIncreaseAddMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Menu::create([
            'label'  => 'Send rent increase',
            'url'    => '#/send-rent-increase',
            'icon'   => 'fa fa-home',
            'roles'  => json_encode(['administrator', 'landlord', 'manager']),
            'status' => 1
        ]);
    }
}
