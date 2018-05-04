<?php

use Illuminate\Database\Seeder;

class FirstHomeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get('database/seeds/scripts/1stHome_Rentling_Data_Migrate.sql'));
		$this->command->info('Tables seeded with 1stHome data.');
    }
}
