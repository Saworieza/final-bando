<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\QuoteResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteResponseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuoteResponse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get or create a quote
        $quote = Quote::inRandomOrder()->first() ?? Quote::factory()->create();
        
        // Get the seller (product owner)
        $seller = $quote->product->user;

        return [
            'quote_id' => $quote->id,
            'seller_id' => $seller->id,
            'price' => $this->faker->randomFloat(2, $quote->product->price * 0.8, $quote->product->price * 1.2),
            'message' => $this->faker->paragraph,
            'estimated_delivery' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'created_at' => $this->faker->dateTimeBetween($quote->created_at, 'now'),
        ];
    }
}