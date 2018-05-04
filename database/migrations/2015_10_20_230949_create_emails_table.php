<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateEmailsTable extends Migration {
        public function up () {
            Schema::create('emails', function (Blueprint $table) {
                $table->increments('id');

                $table->string('email_subject');
                $table->string('event');
                $table->string('status');
                $table->string('language_id');

                $table->unsignedInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

                $table->timestamps();
                $table->softDeletes();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::drop('emails');
        }
    }


