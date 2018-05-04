<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPropertiesFinancialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_financials', function (Blueprint $table) {
            $table->unsignedInteger('currency_id')->nullable()->after('id');
            $table->tinyInteger('rent_tax_included')->default(0)->after('rent_total');
            $table->tinyInteger('commission_tax_included')->default(0)->after('commission');
            $table->tinyInteger('deposit_tax_included')->default(0)->after('deposit');
            $table->tinyInteger('late_fee_tax_included')->default(0)->after('late_fee');
            //
            $table->double('rent_total_calculated', 6, 2)->nullable()->after('rent_total');
            $table->double('commission_total', 6, 2)->nullable()->after('commission');
            $table->double('deposit_total', 6, 2)->nullable()->after('deposit');
            $table->double('late_fee_total', 6, 2)->nullable()->after('late_fee');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
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
            $table->dropForeign('property_financials_currency_id_foreign');
            $table->dropColumn(
                'rent_total_calculated',
                'rent_tax_included',
                'commission_total',
                'commission_tax_included',
                'deposit_total',
                'deposit_tax_included',
                'late_fee_total',
                'late_fee_tax_included',
                'currency_id'
            );
        });
    }
}
