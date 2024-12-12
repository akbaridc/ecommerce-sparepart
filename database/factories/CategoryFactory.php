<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = Faker::create();

        $category = $faker->word;
        $category = $faker->sentence(2);

        return [
            'name' => $category,
            'slug' => Str::slug($category),
        ];
    }
}
