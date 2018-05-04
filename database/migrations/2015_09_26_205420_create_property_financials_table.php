<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePropertyFinancialsTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('property_financials', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->unsignedInteger('property_id')->nullable();

                $table->double('rent', 6, 2);
                $table->tinyInteger('deposit_status')->default(0);
                $table->integer('rent_tax')->nullable();
                $table->double('rent_total', 6, 2)->nullable();

                ## deposit and commission amounts
                $table->double('deposit', 6, 2)->nullable();
                $table->double('commission', 6, 2)->nullable();
                ## deposit and commission taxes
                $table->integer('deposit_tax')->nullable();
                $table->integer('commission_tax')->nullable();

                $table->double('late_fee', 5, 2)->nullable();
                $table->enum('late_fee_delay', ['1w', '2w', '1m'])->nullable();
                $table->integer('late_fee_tax')->nullable();

                $table->unsignedInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

                $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');

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
            Schema::drop('property_financials');
        }
    }
