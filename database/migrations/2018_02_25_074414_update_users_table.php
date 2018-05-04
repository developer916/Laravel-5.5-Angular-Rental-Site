<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('confirmed')
				->nullable(false)
				->default(0);
			$table->tinyInteger('admin')
				->nullable(false)
				->default(0);
			$table->string('confirmation_code', 255)
				->nullable(false);
			$table->tinyInteger('parent_id')
				->nullable(false)
				->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['confirmed', 'admin', 'confirmation_code', 'parent_id']);
        });
    }
}
