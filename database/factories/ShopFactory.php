<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'biography' => $this->faker->paragraph(),
            'theme' => $this->faker->word(),
            'logo' => $this->faker->imageUrl(640, 480, 'business', true),
            'user_id' => DB::table('users')->inRandomOrder()->first()->id,
        ];
    }
}
