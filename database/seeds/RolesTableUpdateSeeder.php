<?php

use Illuminate\Database\Seeder;
use \Kodeine\Acl\Models\Eloquent\Role as Role;

class RolesTableUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role        = new Role();
        $role->create([
            'name'        => 'DepositRelayLandlord',
            'slug'        => 'depoistrelaylandlord',
            'description' => 'Deposit Relay Landlord'
        ]);

        $role        = new Role();
        $role->create([
            'name'        => 'DepositRelayTenant',
            'slug'        => 'depoistrelaytenant',
            'description' => 'Deposit Relay Tenant'
        ]);
    }
}
