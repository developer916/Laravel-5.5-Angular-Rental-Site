<?php

use Illuminate\Database\Seeder;

class TransactionCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\TransactionCategory::create([
            'title' => 'Rent',
            'transaction_recurring_id' => 3
        ]);
        \App\Models\TransactionCategory::create([
            'title' => 'Deposit',
        ]);
        \App\Models\TransactionCategory::create([
            'title' => 'Commission',
        ]);
        \App\Models\TransactionCategory::create([
            'title' => 'Internet',
            'transaction_recurring_id' => 3
        ]);
        \App\Models\TransactionCategory::create([
            'title' => 'Utilities',
            'transaction_recurring_id' => 3
        ]);
        \App\Models\TransactionCategory::create([
            'title' => 'Cleaning',
        ]);
    }
}
