<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {

        return [
            'price' => $this->faker->randomFloat(2, 1, 100),
            'name' => $this->faker->unique()->words(2, true),
            'category_id' => null,
            'points_required' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(),
        ];
    }
}
