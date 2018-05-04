<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagePropertyRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_property', function(Blueprint $table) {
            $table->unsignedInteger('message_id');
            $table->unsignedInteger('property_id');

            $table->boolean('public')->default(false);
            $table->softDeletes();

            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('message_id')->references('id')->on('messages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_property', function(Blueprint $table) {
            $table->dropForeign('message_property_message_id_foreign');
            $table->dropForeign('message_property_property_id_foreign');
        });
        Schema::drop('message_property');
    }
}
