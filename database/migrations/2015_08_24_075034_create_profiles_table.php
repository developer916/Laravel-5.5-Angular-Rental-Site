<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateProfilesTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('profiles', function ($table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();

                $table->string('phone', 55);
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('country')->nullable();
                $table->string('website', 255)->nullable();
                $table->string('bio', 500)->nullable();
                $table->string('avatar', 125)->nullable();
                $table->boolean('visibility')->default(1); // 1 - for public, 0 for private
                $table->string('notifications')->nullable();

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
            Schema::drop('profiles');
        }
    }
