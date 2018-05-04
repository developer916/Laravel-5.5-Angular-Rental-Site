<?php

	use Illuminate\Database\Seeder;

	class ClientsTableSeeder extends Seeder {
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run () {
			\App\Models\Client::create([
				'name'   => 'ECE',
				'domain' => 'ece.rentomato.com'
			]);
			\App\Models\Client::create([
				'name'   => 'Hospa',
				'domain' => 'hospa.rentomato.com'
			]);
			\App\Models\Client::create([
				'name'   => 'Rotterdams',
				'domain' => 'rotterdams.rentomato.com'
			]);
			\App\Models\Client::create([
				'name'   => 'SU',
				'domain' => 'su.rentomato.com'
			]);
		}
	}
