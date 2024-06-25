<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * Test user creation.
     */
    public function test_user_creation(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /**
     * Test user update.
     */
    public function test_user_update(): void
    {
        $user = User::factory()->create();
        $user->name = 'Updated Name';
        $user->save();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    /**
     * Test user deletion.
     */
    public function test_user_deletion(): void
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
