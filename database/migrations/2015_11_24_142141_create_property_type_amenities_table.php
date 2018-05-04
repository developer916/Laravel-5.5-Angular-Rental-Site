<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTypeAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_type_amenities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('amenity_id')->nullable();
            $table->unsignedInteger('property_type_id')->nullable();
            $table->timestamps();
            $table->foreign('amenity_id')->references('id')->on('amenities')->onDelete('set null');
            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_type_amenities', function (Blueprint $table) {
            $table->dropForeign('property_type_amenities_amenity_id_foreign');
            $table->dropForeign('property_type_amenities_property_type_id_foreign');
        });
        Schema::drop('property_type_amenities');
    }
}
