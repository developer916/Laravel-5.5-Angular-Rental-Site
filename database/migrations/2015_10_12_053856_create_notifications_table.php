<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateNotificationsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('notifications', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');

                $table->string('action');
                $table->integer('creator_id');
                $table->integer('receiver_id')->nullable();
                $table->string('message')->nullable();

                $table->timestamps();
                $table->softDeletes();
                //                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                //                $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
                //                $table->foreign('receiver_id')->references('id')->on('users')->onDelete('set null');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::drop('notifications');
        }
    }
