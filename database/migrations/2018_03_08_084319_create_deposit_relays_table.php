<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositRelaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_relays', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('house_number', 10)->nullable();
            $table->string('street', 200)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country');
            $table->dateTime('move_in_date');
            $table->string('landlord_name', 1000);
            $table->string('landlord_email', 1000);
            $table->string('landlord_mobile', 20);
            $table->string('landlord_password', 1000);
            $table->decimal('rent', 10, 0);
            $table->string('tenant_first_name', 200);
            $table->string('tenant_last_name', 800);
            $table->string('tenant_mobile', 20);
            $table->string('tenant_email', 1000);
            $table->string('tenant_password',1000);
            $table->string('currency', 32);
            $table->integer('is_cancelled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit_relays');
    }
}
