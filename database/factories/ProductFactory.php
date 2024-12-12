<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

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
            'category_id' => Category::factory(),
            'name' => fake()->name(),
            'description' => fake()->text(),
            'short_description' => fake()->text('50'),
            'price' => fake()->randomFloat(2, 0, 10000),
            'stock' => fake()->randomFloat(2, 0, 1000)
        ];
    }
}
