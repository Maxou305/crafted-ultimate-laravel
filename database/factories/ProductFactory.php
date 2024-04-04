<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'story' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'quantity' => $this->faker->numberBetween(0, 100),
            'image' => $this->faker->imageUrl(640, 480, 'food', true),
            'category' => $this->faker->word(),
            'color' => $this->faker->colorName(),
            'material' => $this->faker->word(),
            'size' => $this->faker->randomElement(['XS', 'S', 'M', 'L', 'XL']),
            'shop_id' => DB::table('shops')->inRandomOrder()->first()->id,
        ];
    }
}
