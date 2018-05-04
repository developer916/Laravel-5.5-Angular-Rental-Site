<?php

use Illuminate\Database\Seeder;

class TransactionRecurringsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\TransactionRecurring::create([
            'title' => 'Weekly',
        ]);
        \App\Models\TransactionRecurring::create([
            'title' => 'Bi-Weekly',
        ]);
        \App\Models\TransactionRecurring::create([
            'title' => 'Monthly',
        ]);
        \App\Models\TransactionRecurring::create([
            'title' => 'Semi-Monthly',
        ]);
        \App\Models\TransactionRecurring::create([
            'title' => 'Annually',
        ]);
        \App\Models\TransactionRecurring::create([
            'title' => 'Semi-Annually',
        ]);
        \App\Models\TransactionRecurring::create([
            'title' => 'Quarterly',
        ]);
    }
}
