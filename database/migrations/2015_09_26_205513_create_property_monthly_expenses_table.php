<?php

    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePropertyMonthlyExpensesTable extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
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
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::drop('property_monthly_expenses');
        }
    }
