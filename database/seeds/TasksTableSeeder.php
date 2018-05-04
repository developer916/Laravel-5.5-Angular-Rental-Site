<?php

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = \App\User::all()->where('email', 'sander+landlord@rentomato.com')->first()->id;

        Task::create([
            'user_id'       => $user_id,
            'name'          => 'Task #1',
            'description'   => 'Description of Task 1.',
            'due'           => Carbon::now(),
            'priority'      => 0
        ]);

        Task::create([
            'user_id'       => $user_id,
            'name'          => 'Task #2',
            'description'   => 'Description of Task 2.',
            'due'           => Carbon::now(),
            'priority'      => 0
        ]);

        $user_id = \App\User::all()->where('email', 'sander+tenant@rentomato.com')->first()->id;

        Task::create([
            'user_id'       => $user_id,
            'name'          => 'Task #1',
            'description'   => 'Description of Task 1 for other user.',
            'due'           => Carbon::now(),
            'priority'      => 0
        ]);
    }
}
