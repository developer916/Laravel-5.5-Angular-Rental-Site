<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Model::unguard();
		// Add calls to Seeders here
		$this->call(LanguagesTableSeeder::class);
		$this->call(ClientsTableSeeder::class);
		$this->call(PropertyTypesTableSeeder::class);
		$this->call(TransactionRecurringsTableSeeder::class);
		$this->call(TransactionCategoriesTableSeeder::class);
		$this->call(CountriesTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(PropertiesTableSeeder::class);
		$this->call(MenuTableSeeder::class);
		$this->call(PropertyTenantTableSeeder::class);
		$this->call(MessagesTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(CurrenciesTableSeeder::class);
		$this->call(TasksTableSeeder::class);
		$this->call(AmenityCategoriesTableSeeder::class);
		$this->call(AmenitiesTableSeeder::class);
		$this->call(PropertyTypeAmenitiesTableSeeder::class);
        $this->call(RolesTableUpdateSeeder::class);
        $this->call(MenuAndRoleUpdateForDepositRelaySeeder::class);
        $this->call(PaymentsPerTenantAddMenu::class);
        $this->call(SendRentIncreaseAddMenu::class);
        $this->call(ContractWorkbenchAddMenu::class);
        $this->call(EnglishI18NTableSeeder::class);
        $this->call(NetherlandI18NTableSeeder::class);
		$this->call(ContractTypesTableSeeder::class);
        $this->call(PromosTableSeeder::class);
        $this->call(FreeFunctionsTableSeeder::class);
		Model::reguard();
    }
}
