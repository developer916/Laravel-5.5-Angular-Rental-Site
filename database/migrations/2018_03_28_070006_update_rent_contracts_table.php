<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRentContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('rent_contracts', function($table) {
            $table->integer('contract_type_id');
			$table->integer('use_as_addendum')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rent_contracts', function($table) {
            $table->dropColumn('contract_type_id');
			$table->dropColumn('use_as_addendum');
        });
    }
}
