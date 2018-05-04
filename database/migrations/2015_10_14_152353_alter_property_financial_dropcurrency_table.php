<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPropertyFinancialDropcurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_financials', function (Blueprint $table) {
            $table->dropForeign('property_financials_currency_id_foreign');
            $table->dropColumn('currency_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_financials', function (Blueprint $table) {
            $table->unsignedInteger('currency_id')->nullable()->after('id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
        });
    }
}
