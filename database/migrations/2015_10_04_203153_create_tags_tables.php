<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('color', 7)->nullable();
            $table->string('icon')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('message_tag', function(Blueprint $table) {
            $table->unsignedInteger('message_id');
            $table->unsignedInteger('tag_id');

            $table->foreign('message_id')->references('id')->on('messages');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function(Blueprint $table) {
            $table->dropForeign('tags_user_id_foreign');
        });
        Schema::table('message_tag', function(Blueprint $table) {
            $table->dropForeign('message_tag_message_id_foreign');
            $table->dropForeign('message_tag_tag_id_foreign');
        });

        Schema::drop('message_tag');
        Schema::drop('tags');
    }
}
