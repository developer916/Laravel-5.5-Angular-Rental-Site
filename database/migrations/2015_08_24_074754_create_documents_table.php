<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateDocumentsTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up () {
			Schema::create('documents', function ($table) {
				$table->engine = 'InnoDB';
				$table->increments('id')->unsigned();
				$table->string('file', 512);
				$table->unsignedInteger('file_size')->nullable();
				$table->string('description', 255)->nullable();
				$table->enum('privacy', ['Private', 'Password', 'Public', 'Friends'])->default('Private');
				$table->unsignedInteger('property_id')->nullable();

                $table->unsignedInteger('user_id')->nullable();
				$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
				$table->integer('folder_id');
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
			Schema::drop('documents');
		}
	}
