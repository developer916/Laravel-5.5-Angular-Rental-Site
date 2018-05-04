<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateTableMenu extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up () {
			Schema::create('menu', function ($table) {
				$table->engine = 'InnoDB';
				$table->increments('id')->unsigned();
				$table->string('label', 255);
				$table->string('url', 255);
				$table->string('icon', 155)->nullable();
				$table->tinyInteger('status');
				$table->string('roles', 225)->nullable();
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
			Schema::drop('menu');
		}
	}
