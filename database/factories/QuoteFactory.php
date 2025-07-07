<?php
// database/factories/QuoteFactory.php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    public function definition()
    {
        // Get existing product and buyer
        $product = Product::inRandomOrder()->first();
        $buyer = User::role('Buyer')->inRandomOrder()->first();
        
        if (!$product) {
            throw new \Exception('No products found. Please seed products first.');
        }

        if (!$buyer) {
            throw new \Exception('No buyers found. Please seed users with Buyer role first.');
        }
        
        return [
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
            'company_name' => $this->faker->company,
            'contact_name' => $this->faker->name,
            'email' => $this->faker->boolean(90) ? $buyer->email : $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'quantity' => $this->faker->numberBetween($product->min_order_quantity, $product->min_order_quantity * 10),
            'message' => $this->faker->boolean(70) ? $this->faker->paragraph : null,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'completed']),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}