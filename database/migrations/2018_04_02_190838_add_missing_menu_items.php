<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingMenuItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// RUN ONLY IN PRODUCTION!
		if (App::environment('production')) {
			\App\Models\Menu::create([
				'label'  => 'Send Rent Increase',
				'url'    => '#/send-rent-increase',
				'icon'   => 'icon-envelope-open',
				'roles'  => json_encode(['administrator', 'landlord', 'manager']),
				'status' => 1
			]);
			
			\App\Models\Menu::create([
				'label'  => 'Payments per tenant',
				'url'    => '#/paymentPerTenant',
				'icon'   => 'icon-envelope-open',
				'roles'  => json_encode(['administrator', 'landlord', 'manager']),
				'status' => 1
			]);
			
			\App\Models\Menu::create([
				'label'  => 'Contracts',
				'url'    => '#/contract/template',
				'icon'   => 'icon-envelope-open',
				'roles'  => json_encode(['administrator', 'landlord', 'manager']),
				'status' => 1
			]);
			
			\App\Models\Menu::create([
				'label'  => 'Contract Workbench',
				'url'    => '#/contract-workbench',
				'icon'   => 'icon-envelope-open',
				'roles'  => json_encode(['administrator', 'landlord', 'manager']),
				'status' => 1
			]);
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
