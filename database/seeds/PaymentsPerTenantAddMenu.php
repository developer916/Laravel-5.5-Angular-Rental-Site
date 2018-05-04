<?php

use Illuminate\Database\Seeder;

class PaymentsPerTenantAddMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Menu::create([
            'label'  => 'Payments per Tenant',
            'url'    => '#/payment-per-tenant',
            'icon'   => 'fa fa-money',
            'roles'  => json_encode(['administrator', 'landlord', 'manager', 'tenant']),
            'status' => 1
        ]);

    }
}
