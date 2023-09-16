<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::factory()->create([
            'message' => 'Hello I am the Users first message in the first Chat.',
            'user_id' => 1,
            'chat_id' => 1,
        ]);

        Message::factory()->create([
            'message' => 'Hello I am the Admin, this is the second message in the first Chat.',
            'user_id' => 2,
            'chat_id' => 1,
        ]);
    }
}
