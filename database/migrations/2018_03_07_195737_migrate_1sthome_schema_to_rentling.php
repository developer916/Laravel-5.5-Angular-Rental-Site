<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Migrate1sthomeSchemaToRentling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(File::get('database/migrations/scripts/1stHome_Rentling_Schema_Migrate.sql'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_info');
        Schema::drop('user_devices');
		Schema::drop('payment_imports');
		Schema::drop('SCaccounts');
		Schema::drop('room_visits');
		Schema::drop('room_visit_notifications');
		Schema::drop('room_cleanings');
		Schema::drop('property_charges');
		Schema::drop('utility_meters');
		Schema::drop('general_charges');
		Schema::drop('deposit_charges');
		Schema::drop('rent_components');
		Schema::drop('rent');
		Schema::drop('rent_contracts');
		Schema::drop('user_property_constants');
		Schema::drop('data_property_names');
		Schema::drop('data_properties');
    }
}
