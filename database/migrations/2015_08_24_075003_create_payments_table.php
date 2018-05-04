<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePaymentsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('payments', function ($table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->unsignedInteger('invoice_id')->nullable();
                $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');

                $table->unsignedInteger('landlord_id');
                $table->unsignedInteger('tenant_id');

                $table->float('amount');
                $table->string('status');

                $table->string('payment_method');
                $table->string('payment_status'); // paid in full or partially paid

                $table->string('merchant_reference')->nullable();
                $table->string('psp_reference')->nullable();
                $table->string('payment_auth_result')->nullable();

                $table->timestamps();
                $table->softDeletes();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::drop('payments');
        }
    }
