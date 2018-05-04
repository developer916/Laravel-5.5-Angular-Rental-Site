<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('property_id')->nullable();
            $table->unsignedInteger('unit_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('transaction_category_id')->nullable();
            $table->unsignedInteger('transaction_recurring_id')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->double('amount_tax', 4, 2)->nullable();
            $table->smallInteger('amount_tax_included')->nullable();
            $table->double('amount_total', 8, 2)->nullable();
            $table->string('description', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('properties')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('transaction_recurring_id')->references('id')->on('transaction_recurrings')->onDelete('set null');
            $table->foreign('transaction_category_id')->references('id')->on('transaction_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_transactions', function (Blueprint $table) {
            $table->dropForeign('property_transactions_transaction_category_id_foreign');
            $table->dropForeign('property_transactions_transaction_recurring_id_foreign');
            $table->dropForeign('property_transactions_property_id_foreign');
            $table->dropForeign('property_transactions_unit_id_foreign');
            $table->dropForeign('property_transactions_user_id_foreign');
        });
        /* Schema::table('property_transactions', function (Blueprint $table) {
             $table->dropForeign('property_transactions_transaction_id_foreign');
         });*/
        Schema::drop('property_transactions');
    }
}
