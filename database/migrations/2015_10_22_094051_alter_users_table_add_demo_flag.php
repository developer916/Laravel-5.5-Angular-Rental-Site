<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AlterUsersTableAddDemoFlag extends Migration {
        public function up () {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('has_demo')->default(1)->after('remember_token');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('has_demo');
            });
        }
    }
