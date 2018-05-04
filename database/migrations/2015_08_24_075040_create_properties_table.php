<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreatePropertiesTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up () {
			Schema::create('properties', function ($table) {
				$table->engine = 'InnoDB';
				$table->increments('id')->unsigned();

				$table->string('title', 255);
				$table->string('slug')->nullable();
				$table->string('address', 255);
				$table->integer('street_no');
				$table->string('street', 125);

				$table->string('city', 125);
				$table->string('state', 125);
				$table->string('post_code', 125);
				$table->string('country', 125);
				$table->float('rental_price');
				$table->tinyInteger('deposit');
				$table->boolean('status')->default(0);
				$table->unsignedInteger('user_id')->nullable();
				$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

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
//			Schema::table('property_photos', function (Blueprint $table) {
//				$table->dropForeign('property_photos_property_id_foreign');
//			});
			Schema::drop('properties');
		}
	}
