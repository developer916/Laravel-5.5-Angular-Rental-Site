<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('title', 64)->nullable();
            $table->unsignedInteger('amenity_category_id')->nullable();
            $table->enum('type', ['TINYINT','INT','VARCHAR','DECIMAL','ENUM']);
            $table->string('value', 64)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('amenity_category_id')->references('id')->on('amenity_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amenities', function (Blueprint $table) {
            $table->dropForeign('amenities_amenity_category_id_foreign');
        });
        Schema::drop('amenities');
    }
}
