<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterI18nTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE i18n MODIFY label VARCHAR(4096) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE i18n MODIFY label_key VARCHAR(4096) NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE i18n MODIFY label VARCHAR(256) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE i18n MODIFY label_key VARCHAR(256) NULL DEFAULT NULL");
    }

}
