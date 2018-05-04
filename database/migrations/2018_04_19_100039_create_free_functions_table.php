<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreeFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_functions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('start_month');
            $table->integer('start_day');
            $table->integer('end_month');
            $table->integer('end_day');
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->string('menu_item_id');
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
        Schema::dropIfExists('free_functions');
    }
}
