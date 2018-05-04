<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateTableI18n extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('i18n', function ($table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();

                $table->string('label', 255);
                $table->string('label_key', 255);

                $table->unsignedInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                $table->unsignedInteger('language_id')->nullable();
                $table->foreign('language_id')->references('id')->on('languages')->onDelete('set null');

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
            // no matter what don't drop this table
           Schema::drop('i18n');
        }
    }
