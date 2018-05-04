<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AlterUsersTableAddLoginFlag extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::table('users', function ($table) {
                $table->boolean('has_login')->default(0);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('has_login');
            });
        }
    }
