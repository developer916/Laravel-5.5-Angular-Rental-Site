<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('invoices',function($table) {
           	$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->unsignedInteger('user_id')->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

			$table->unsignedInteger('landlord_id')->nullable();
			$table->foreign('landlord_id')->references('id')->on('users')->onDelete('set null');

			$table->unsignedInteger('tenant_id')->nullable();
			$table->foreign('tenant_id')->references('id')->on('users')->onDelete('set null');

            $table->tinyInteger('status')->default(1);
            $table->float('amount');
            $table->integer('discount');
            $table->tinyInteger('currency');


			$table->string('notes', 255)->nullable();
			$table->string('description', 255)->nullable();
            $table->dateTime('due_at');
			$table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoices');
    }
}
