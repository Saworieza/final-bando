<?php

// database/factories/QuoteResponseFactory.php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteResponseFactory extends Factory
{
    public function definition()
    {
        $quote = Quote::inRandomOrder()->first() ?? Quote::factory()->create();
        $seller = $quote->product->user;
        
        return [
            'quote_id' => $quote->id,
            'seller_id' => $seller->id,
            'price' => $this->faker->randomFloat(2, $quote->product->price * 0.8, $quote->product->price * 1.2),
            'message' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeBetween($quote->created_at, 'now'),
        ];
    }
}