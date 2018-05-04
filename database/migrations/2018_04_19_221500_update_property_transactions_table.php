<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePropertyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('property_transactions', function($table) {
            $table->double('service_cost', 8, 2)->nullable();
            $table->date('notification_active_from')->nullable();
            $table->date('notification_active_to')->nullable();
            $table->date('effective_date')->nullable();
            $table->string('notification_document',256)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_transactions', function($table) {
            $table->dropColumn('service_cost');            
            $table->dropColumn('notification_active_from');
			$table->dropColumn('notification_active_to');
            $table->dropColumn('effective_date');
            $table->dropColumn('notification_document');                        
        });
    }
}
