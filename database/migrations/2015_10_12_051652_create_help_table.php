<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateHelpTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('help', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('language_id')->unsigned();
                $table->string('uri');
                $table->string('title');
                $table->string('content', 1024);
                $table->string('video')->nullable();
                $table->timestamps();
                $table->softDeletes();
//                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
//                $table->foreign('language_id')->references('id')->on('languages')->onDelete('set null');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::drop("help");
        }
    }
