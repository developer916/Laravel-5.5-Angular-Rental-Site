<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AlterUsersTableZeroDemoFlag extends Migration {
        public function up () {
            DB::statement("ALTER TABLE users MODIFY has_demo tinyint(4) DEFAULT '0' ");
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
           DB::statement("ALTER TABLE users MODIFY has_demo tinyint(4) NOT NULL DEFAULT '1' ");
        }
    }
