<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AlterPropertiesAddLatlng extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::table('properties', function (Blueprint $table) {
                $table->double('lat', 9, 6)->after('country');
                $table->double('lng', 9, 6)->after('country');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::table('properties', function (Blueprint $table) {
                $table->dropColumn(['lat', 'lng']);
            });
        }
    }
