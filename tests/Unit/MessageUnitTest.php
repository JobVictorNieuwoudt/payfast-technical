<?php

namespace Tests\Unit;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class MessageUnitTest extends TestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function test_that_messages_can_be_created(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $chat = Chat::factory()->create([
            'description' => 'Test Chat',
            'user_id' => $user->id,
        ]);

        $message = Message::factory()->create([
            'message' => 'Test Message',
            'user_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        $this->assertDatabaseHas('messages', [
            'message' => 'Test Message',
            'user_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        $this->assertTrue(true);
    }


    public function test_that_messages_can_be_updated(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $chat = Chat::factory()->create([
            'description' => 'Test Chat',
            'user_id' => $user->id,
        ]);

        $message = Message::factory()->create([ // Create and save the initial message
            'message' => 'Test Message',
            'user_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        // Retrieve the message from the database
        $message = Message::find($message->id);

        // Update the message
        $message->message = "Updated Message";
        $message->save(); // Save the updated message to the database

        $this->assertDatabaseHas('messages', [
            'message' => 'Updated Message',
            'user_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        $this->assertTrue(true);
    }


    public function test_that_messages_can_be_deleted(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $chat = Chat::factory()->create([
            'description' => 'Test Chat',
            'user_id' => $user->id,
        ]);

        $message = Message::factory()->create([
            'message' => 'Test Message',
            'user_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        // Delete the message
        $message->delete();

        $this->assertDatabaseMissing('messages', [
            'message' => 'Test Message',
            'user_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        $this->assertTrue(true);
    }


    public function test_that_messages_can_be_fetched_by_id(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $chat = Chat::factory()->create([
            'description' => 'Test Chat',
            'user_id' => $user->id,
        ]);

        // Create a message and save it to the database
        $message = Message::factory()->create([
            'message' => 'Test Message',
            'user_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        // Fetch the message by its ID
        $fetchedMessage = Message::find($message->id);

        $this->assertEquals($message->message, $fetchedMessage->message);
        $this->assertEquals($message->user_id, $fetchedMessage->user_id);
        $this->assertEquals($message->chat_id, $fetchedMessage->chat_id);

        $this->assertTrue(true);
    }


    public function test_that_fetch_messages_list(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $chat = Chat::factory()->create([
            'description' => 'Test Chat',
            'user_id' => $user->id,
        ]);

        Message::factory()->create([
            'message' => 'Test Message 1',
            'user_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        Message::factory()->create([
            'message' => 'Test Message 2',
            'user_id' => $user->id,
            'chat_id' => $chat->id,
        ]);

        $messages = Message::all();

        $this->assertCount(2, $messages);

        $this->assertTrue(true);
    }
}
