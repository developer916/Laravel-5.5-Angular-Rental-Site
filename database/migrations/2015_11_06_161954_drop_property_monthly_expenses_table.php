<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPropertyMonthlyExpensesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('property_monthly_expenses');
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('property_monthly_expenses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->enum('type', ['Internet','Utilities','Cleaning']);
            $table->double('amount',6,2)->nullable();
            $table->integer('amount_tax')->nullable();

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->unsignedInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('property_monthly_expenses', function (Blueprint $table) {
            $table->double('amount_total',6,2)->nullable()->after('amount');
            $table->tinyInteger('amount_tax_included')->default(0)->after('amount');
        });
        DB::statement("ALTER TABLE `property_monthly_expenses` CHANGE `type` `type` ENUM('Internet','Utilities','Cleaning','Other') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;");
    }

}
