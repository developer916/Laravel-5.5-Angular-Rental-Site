<?php

use Illuminate\Database\Seeder;
use \Kodeine\Acl\Models\Eloquent\Role as Role;
use App\Models\Menu;

class MenuAndRoleUpdateForDepositRelaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')
            ->where('slug', 'depoistrelaylandlord')
            ->update(['name' => 'DepositRelay', 'slug' => 'depositrelay', 'description' => 'Deposit Relay']);
        DB::table('roles')->where('slug',  'depoistrelaytenant')->delete();

        $menu = Menu::where('label', 'Dashboard')->first();
        $menu->roles = '["administrator","tenant","landlord","manager","depositrelay"]';
        $menu->save();

        $menu = Menu::where('label', 'Settings')->first();
        $menu->roles = '["administrator","tenant","landlord","manager","depositrelay"]';
        $menu->save();
    }
}
