<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Tests\TestCase;

class ShopTest extends TestCase
{
    /**
     * Test if an order has user creation.
     */
    public function test_it_has_a_user_relationship()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $shop->user);
        $this->assertEquals($user->id, $shop->user->id);
    }

    /**
     * Test if an order has products creation.
     */
    public function test_it_has_products_relationship()
    {
        $shop = Shop::factory()->create();
        $product = Product::factory()->create(['shop_id' => $shop->id]);

        $this->assertInstanceOf(Product::class, $shop->products->first());
        $this->assertEquals($product->id, $shop->products->first()->id);
    }

    /**
     * Test if an order has fillable attributes.
     */
    public function test_it_has_fillable_attributes()
    {
        $shop = new Shop();

        $fillable = ['name', 'user_id', 'biography', 'theme', 'logo'];

        $this->assertEquals($fillable, $shop->getFillable());
    }
}
