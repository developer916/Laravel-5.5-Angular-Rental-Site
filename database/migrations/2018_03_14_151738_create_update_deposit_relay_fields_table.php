<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateDepositRelayFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_relays', function(Blueprint $table) {
            $table->string('bank_name')->nullable();
            $table->string('state')->nullable();
            $table->integer('tenant_id')->nullable();
            $table->integer('landlord_id')->nullable();
            $table->integer('status')->default(0);
            $table->longText('cancel_reason')->nullable();
            $table->dropColumn('landlord_password');
            $table->dropColumn('tenant_password');
            $table->dropColumn('is_cancelled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposit_relays', function(Blueprint $table) {
            $table->dropColumn('bank_name');
            $table->dropColumn('state');
            $table->dropColumn('tenant_id');
            $table->dropColumn('landlord_id');
            $table->dropColumn('status');
            $table->dropColumn('cancel_reason');
            $table->string('landlord_password')->nullable();
            $table->string('tenant_password')->nullable();
            $table->integer('is_cancelled')->nullable();
        });
    }
}
