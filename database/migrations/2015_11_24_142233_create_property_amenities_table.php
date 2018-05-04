<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_amenities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('amenity_id')->nullable();
            $table->unsignedInteger('property_id')->nullable();
            $table->string('value', 255)->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            $table->foreign('amenity_id')->references('id')->on('amenities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_amenities', function (Blueprint $table) {
            $table->dropForeign('property_amenities_property_id_foreign');
            $table->dropForeign('property_amenities_amenity_id_foreign');
        });
        Schema::drop('property_amenities');
    }
}
