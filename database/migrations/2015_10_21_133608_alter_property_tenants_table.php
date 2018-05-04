<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPropertyTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_tenants', function (Blueprint $table) {
            $table->dropColumn('contract_period');
            $table->dropColumn('rent');
            $table->dropColumn('assigned_at');
            $table->unsignedInteger('unit_id')->nullable()->after('user_id');
            $table->foreign('unit_id')->references('id')->on('properties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_tenants', function (Blueprint $table) {
            $table->timestamp('assigned_at')->useCurrent();
            $table->tinyInteger('contract_period')->nullable();
            $table->float('rent');
            $table->dropForeign('property_tenants_unit_id_foreign');
            $table->dropColumn('unit_id');
        });
    }
}
