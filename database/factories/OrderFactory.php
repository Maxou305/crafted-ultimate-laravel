<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => $this->faker->randomNumber(),
            'user_id' => DB::table('users')->inRandomOrder()->first()->id,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'validatedStatus' => $this->faker->boolean(),
            'shippingCountry' => $this->faker->country(),
            'shippingMode' => $this->faker->word(),
            'shippingPrice' => $this->faker->randomFloat(2, 0, 100),
            'creatorCode' => $this->faker->word(),
            'promoCode' => $this->faker->word(),
        ];
    }
}
