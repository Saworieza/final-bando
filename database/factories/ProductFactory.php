<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

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
            'name' => $this->faker->words(2, true),
            'sku' => strtoupper($this->faker->unique()->lexify('SKU-????')),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'min_order_qty' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->sentence(),
            'category' => $this->faker->word(),
            'tags' => implode(',', $this->faker->words(3)),
            'status' => 'active',
        ];
    }
}
