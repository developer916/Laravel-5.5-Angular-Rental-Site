<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $msg1 = \App\Models\Message::create([
            'thread'            => 1,
            'sender_id'         => 2,
            'text'              => 'A sample message for you!',
            'subject'           => 'This is a message',
            'priority'          => 0,
            'type'              => 'message',
            'to'                =>1
        ]);
        $msg1->recipients()->attach(1, ['starred' => 1]);
        $msg1->recipients()->attach(3);

        $msg2 = \App\Models\Message::create([
            'thread'            => 1,
            'sender_id'         => 3,
            'text'              => 'This is another text',
            'subject'           => 'This is a new subject for within the same thread',
            'priority'          => 1,
            'type'              => 'message',
            'to'                =>1
        ]);
        $msg2->recipients()->attach(1);
        $msg2->recipients()->attach(2);

        $msg3 = \App\Models\Message::create([
            'thread'            => 2,
            'sender_id'         => 1,
            'text'              => 'You earned 5 billion nothings!',
            'subject'           => 'You have won the jackpot!',
            'priority'          => -1,
            'type'              => 'messages',
            'to'                =>1
        ]);
        $msg3->recipients()->attach(1);
    }
}
