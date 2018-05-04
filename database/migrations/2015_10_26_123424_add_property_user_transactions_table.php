<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPropertyUserTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_user_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('property_transaction_id')->nullable();
            $table->unsignedInteger('transaction_type_id')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_user_transactions', function (Blueprint $table) {
            $table->dropForeign('property_user_transactions_user_id_foreign');
            $table->dropForeign('property_user_transactions_transaction_type_id_foreign');
        });
        Schema::drop('property_user_transactions');
    }
}
