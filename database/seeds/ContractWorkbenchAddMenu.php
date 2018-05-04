<?php

use Illuminate\Database\Seeder;

class ContractWorkbenchAddMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Menu::create([
            'label'  => 'Contract workbench',
            'url'    => '#/contract-workbench',
            'icon'   => 'fa fa-list',
            'roles'  => json_encode(['administrator', 'landlord', 'manager']),
            'status' => 1
        ]);
    }
}
