<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * Test if an order has user creation.
     */
    public function test_it_has_a_user_relationship()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $order->user);
        $this->assertEquals($user->id, $order->user->id);
    }

    /**
     * Test if an order has products creation.
     */
    public function test_it_has_products_relationship()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $order->products()->attach($product->id, ['quantity' => 1, 'price' => 100, 'size' => 'M', 'color' => 'Red', 'material' => 'Cotton']);

        $this->assertInstanceOf(Product::class, $order->products->first());
        $this->assertEquals($product->id, $order->products->first()->id);
        $this->assertEquals('M', $order->products->first()->pivot->size);
        $this->assertEquals('Red', $order->products->first()->pivot->color);
    }

    /**
     * Test if an order has fillable attributes.
     */
    public function test_it_has_fillable_attributes()
    {
        $order = new Order();

        $fillable = ['user_id', 'order_number', 'price', 'validatedStatus', 'shippingCountry', 'shippingMode', 'shippingPrice', 'creatorCode', 'promoCode'];

        $this->assertEquals($fillable, $order->getFillable());
    }

    /**
     * Test if an order has hidden attributes.
     */
    public function test_it_has_hidden_attributes()
    {
        $order = new Order();

        $hidden = ['user_id', 'updated_at'];

        $this->assertEquals($hidden, $order->getHidden());
    }
}
