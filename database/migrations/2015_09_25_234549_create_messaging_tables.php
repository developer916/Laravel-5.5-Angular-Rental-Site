<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Table to store the actual messages
        Schema::create('messages', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('thread');
            $table->string('subject');
            $table->text('text');
            $table->unsignedInteger('sender_id');
            $table->integer('priority')->default(0);
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sender_id')->references('id')->on('users');
        });

        // Create the table where we keep track of recipients
        Schema::create('message_user', function(Blueprint $table) {
            $table->unsignedInteger('message_id');
            $table->unsignedInteger('user_id');

            $table->boolean('read')->default(false);
            $table->boolean('starred')->default(false);
            $table->timestamp('read_date')->nullable();
            $table->timestamp('postponed_date')->nullable();
            $table->softDeletes();

            $table->foreign('message_id')->references('id')->on('messages');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_user', function(Blueprint $table) {
            $table->dropForeign('message_user_message_id_foreign');
            $table->dropForeign('message_user_user_id_foreign');
        });
        Schema::drop('message_user');

        Schema::table('messages', function(Blueprint $table) { $table->dropForeign('messages_sender_id_foreign');} );
        Schema::drop('messages');
    }
}
