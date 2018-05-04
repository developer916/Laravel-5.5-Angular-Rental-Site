<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPropertyAmenitiesTableSetOnDeleteCascadeProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_amenities', function (Blueprint $table) {
            $table->dropForeign('property_amenities_property_id_foreign');
            $table->dropForeign('property_amenities_amenity_id_foreign');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('amenity_id')->references('id')->on('amenities')->onDelete('cascade');

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
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            $table->foreign('amenity_id')->references('id')->on('amenities')->onDelete('set null');
        });
    }
}
