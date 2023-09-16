<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

class UserUnitTest extends TestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function test_that_users_can_be_created(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => $user->email,
        ]);

        $this->assertTrue(true);
    }

    public function test_that_users_can_be_updated(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $user->name = "Jane Doe";
        $user->save();

        $this->assertDatabaseHas('users', [
            'name' => 'Jane Doe',
            'email' => $user->email,
        ]);

        $this->assertTrue(true);
    }

    public function test_that_users_can_be_deleted(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'name' => 'John Doe',
            'email' => $user->email,
        ]);

        $this->assertTrue(true);
    }

    public function test_that_users_can_be_fetched_by_id(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $fetchedUser = User::find($user->id);

        $this->assertEquals($user->name, $fetchedUser->name);
        $this->assertEquals($user->email, $fetchedUser->email);

        $this->assertTrue(true);
    }

    public function test_that_fetch_users_list(): void
    {
        User::factory()->create([
            'name' => 'John Doe1',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Jane Doe2',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);

        $users = User::all();

        $this->assertCount(2, $users);

        $this->assertTrue(true);
    }

}
