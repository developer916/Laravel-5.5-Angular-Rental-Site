<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPropertyMonthlyExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_monthly_expenses', function (Blueprint $table) {
            $table->double('amount_total',6,2)->nullable()->after('amount');
            $table->tinyInteger('amount_tax_included')->default(0)->after('amount');
        });
        DB::statement("ALTER TABLE `property_monthly_expenses` CHANGE `type` `type` ENUM('Internet','Utilities','Cleaning','Other') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_monthly_expenses', function (Blueprint $table) {
            $table->dropColumn('amount_total','amount_tax_included');
        });
        DB::statement("ALTER TABLE `property_monthly_expenses` CHANGE `type` `type` ENUM('Internet','Utilities','Cleaning') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;");
    }
}
