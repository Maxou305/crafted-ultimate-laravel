<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Order;
use App\Models\Shop;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * Test user creation.
     */
    public function test_user_creation()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /**
     * Test user update.
     */
    public function test_user_update()
    {
        $user = User::factory()->create();
        $user->name = 'Updated Name';
        $user->save();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    /**
     * Test user deletion.
     */
    public function test_user_deletion()
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /**
     * Test if user has comments relationship.
     */
    public function test_wrong_id_raise_an_error()
    {
        $id = Uuid::uuid4()->toString();
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)->get('api/users/'. $id);

        $response->assertStatus(404);
    }

    /**
     * Test if user has comments relationship.
     */
    public function test_it_has_a_shop_relationship()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Shop::class, $user->shop);
        $this->assertEquals($shop->id, $user->shop->id);
    }

    /**
     * Test if user has an order relationship.
     */
    public function test_it_has_an_order_relationship()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Order::class, $user->order);
        $this->assertEquals($order->id, $user->order->id);
    }

    /**
     * Test if user has comments relationship.
     */
    public function test_it_has_comments_relationship()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Comment::class, $user->comments->first());
        $this->assertEquals($comment->id, $user->comments->first()->id);
    }
    /**
     * Test if user cast attributes are correctly cast.
     */
    public function test_it_has_casts_attribute()
    {
        $user = new User();

        $this->assertArrayHasKey('email_verified_at', $user->getCasts());
        $this->assertArrayHasKey('password', $user->getCasts());
    }

    /**
     * Test if user has hidden attributes.
     */
    public function test_it_has_hidden_attributes()
    {
        $user = new User();

        $this->assertContains('password', $user->getHidden());
        $this->assertContains('remember_token', $user->getHidden());
        $this->assertContains('email_verified_at', $user->getHidden());
        $this->assertContains('created_at', $user->getHidden());
        $this->assertContains('updated_at', $user->getHidden());
    }
}
