<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPropertyUserTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_user_transactions', function (Blueprint $table) {
            $table->foreign('property_transaction_id')->references('id')->on('property_transactions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_user_transactions', function (Blueprint $table) {
            $table->dropForeign('property_user_transactions_property_transaction_id_foreign');

        });
    }
}
