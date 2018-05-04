<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class AlterInvoicesTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up () {
			Schema::table('invoices', function ($table) {
				$table->unsignedInteger('property_id')->nullable();
				$table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down () {
			Schema::table('invoices', function ($table) {
                $table->dropForeign('invoices_property_id_foreign');
				$table->dropColumn('property_id');
			});
		}
	}
