<?php

namespace Tests\Unit;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class ChatUnitTest extends TestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function test_that_chats_can_be_created(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        Chat::factory()->create([
            'description' => 'Test Chat',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('chats', [
            'description' => 'Test Chat',
            'user_id' => $user->id,
        ]);

        $this->assertTrue(true);
    }

    public function test_that_chats_can_be_updated(): void
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

        $chat->description = "Updated Chat";
        $chat->save();

        $this->assertDatabaseHas('chats', [
            'description' => 'Updated Chat',
            'user_id' => $user->id,
        ]);

        $this->assertTrue(true);
    }

    public function test_that_chats_can_be_deleted(): void
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

        $chat->delete();

        $this->assertDatabaseMissing('chats', [
            'description' => 'Test Chat',
            'user_id' => $user->id,
        ]);

        $this->assertTrue(true);
    }

    public function test_that_chats_can_be_fetched_by_id(): void
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

        $fetchedChat = Chat::find($chat->id);

        $this->assertEquals($chat->description, $fetchedChat->description);
        $this->assertEquals($chat->user_id, $fetchedChat->user_id);

        $this->assertTrue(true);
    }

    public function test_that_fetch_chats_list(): void
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

        $chat2 = Chat::factory()->create([
            'description' => 'Test Chat 2',
            'user_id' => $user->id,
        ]);

        $chats = Chat::all();

        $this->assertCount(2, $chats);

        $this->assertTrue(true);
    }
}
