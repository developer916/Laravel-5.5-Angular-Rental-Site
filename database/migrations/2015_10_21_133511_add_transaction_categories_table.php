<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("transaction_categories", function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',64)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('transaction_recurring_id')->nullable();
            $table->tinyInteger('weight')->nullable();
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
        Schema::drop("transaction_categories");
    }
}
