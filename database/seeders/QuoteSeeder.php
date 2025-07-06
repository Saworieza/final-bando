<?php

namespace Database\Seeders;

use App\Models\Quote;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users with different roles
        $buyers = User::whereHas('roles', function($query) {
            $query->where('name', 'Buyer');
        })->get();
        
        $sellers = User::whereHas('roles', function($query) {
            $query->where('name', 'Seller');
        })->get();
        
        $products = Product::with('user')->get();
        
        if ($buyers->isEmpty() || $sellers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Please ensure you have users with Buyer/Seller roles and products before running this seeder.');
            return;
        }

        $messages = [
            'Hi, I am interested in bulk purchasing this product. Could you provide a quote for 50 units? I need them delivered within 2 weeks.',
            'Hello! I run a small business and would like to know your best price for 25 units. Can you also tell me about your payment terms?',
            'Good day! I am looking for a quote on this product. I need 10 units for a project starting next month. What would be your best offer?',
            'Hi there! I am interested in this product for my retail store. Can you quote me for 100 units? Also, do you offer any volume discounts?',
            'Hello! I need this product for an upcoming event. Could you provide a rush quote for 20 units? Timeline is quite tight.',
            'Hi! I am comparing suppliers and would like your quote for 15 units. Quality is very important to me. What certifications do you have?',
            'Good morning! I am interested in a long-term partnership. Can you quote me for 200 units as a starting order?',
            'Hello! I represent a company that might need regular supplies of this product. Could you provide a quote for 75 units?',
        ];

        $responses = [
            'Thank you for your interest! I can offer you a competitive price per unit for your quantity. The quality is guaranteed and I can meet your delivery timeline.',
            'Hello! I appreciate your inquiry. For the quantity you mentioned, I can provide a special discount. Payment terms are flexible.',
            'Hi! I would be happy to work with you on this. For your order size, I can offer a great price. This includes quality assurance and timely delivery.',
            'Thank you for considering my product! I can definitely accommodate your volume requirements. Additional discounts available for bulk orders.',
            'Hello! I understand the urgency of your project. I can expedite the order. Rush delivery is available at a small additional cost.',
            'Hi there! Quality is indeed our priority. We have all necessary certifications. I can provide a competitive quote for your quantity.',
            'Good day! I am excited about the possibility of a long-term partnership. I can offer better rates for future orders.',
            'Hello! I would love to work with your company on regular supplies. Volume discounts available for ongoing orders.',
        ];

        $statuses = ['pending', 'replied', 'accepted', 'rejected', 'fulfilled'];
        $quantities = [10, 15, 20, 25, 50, 75, 100, 150, 200];

        // Create quotes with different statuses
        foreach ($products as $product) {
            // Create 2-4 quotes per product
            $quotesPerProduct = rand(2, 4);
            
            for ($i = 0; $i < $quotesPerProduct; $i++) {
                $buyer = $buyers->random();
                $seller = $product->user;
                $quantity = $quantities[array_rand($quantities)];
                $status = $statuses[array_rand($statuses)];
                
                // Skip if buyer is the same as seller
                if ($buyer->id === $seller->id) {
                    continue;
                }
                
                // Calculate price based on product price and quantity
                $basePrice = $product->price ?? rand(10, 500);
                $requestedPrice = $basePrice;
                
                // Apply bulk discount for quoted price
                $quotedPrice = $basePrice;
                if ($quantity >= 100) {
                    $quotedPrice = $basePrice * 0.85; // 15% discount
                } elseif ($quantity >= 50) {
                    $quotedPrice = $basePrice * 0.9; // 10% discount
                } elseif ($quantity >= 25) {
                    $quotedPrice = $basePrice * 0.95; // 5% discount
                }
                
                // Create the quote
                $quoteData = [
                    'buyer_id' => $buyer->id,
                    'seller_id' => $seller->id,
                    'product_id' => $product->id,
                    'item_name' => $product->name,
                    'quantity' => $quantity,
                    'requested_price' => round($requestedPrice, 2),
                    'message' => $messages[array_rand($messages)],
                    'status' => $status,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 5)),
                ];
                
                // Add quoted price if not pending
                if ($status !== 'pending') {
                    $quoteData['quoted_price'] = round($quotedPrice, 2);
                }
                
                $quote = Quote::create($quoteData);
                
                // Add seller response if quote is not pending
                if ($status !== 'pending') {
                    $quote->update([
                        'seller_response' => $responses[array_rand($responses)],
                        'responded_at' => now()->subDays(rand(0, 5)),
                    ]);
                }
            }
        }

        // Create some additional quotes between random buyers and sellers
        for ($i = 0; $i < 20; $i++) {
            $buyer = $buyers->random();
            $product = $products->random();
            $seller = $product->user;
            
            // Skip if buyer is the same as seller
            if ($buyer->id === $seller->id) {
                continue;
            }
            
            $quantity = $quantities[array_rand($quantities)];
            $status = $statuses[array_rand($statuses)];
            
            $basePrice = $product->price ?? rand(10, 500);
            $requestedPrice = $basePrice;
            
            // Apply bulk discount for quoted price
            $quotedPrice = $basePrice;
            if ($quantity >= 100) {
                $quotedPrice = $basePrice * 0.85;
            } elseif ($quantity >= 50) {
                $quotedPrice = $basePrice * 0.9;
            } elseif ($quantity >= 25) {
                $quotedPrice = $basePrice * 0.95;
            }
            
            $quoteData = [
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'product_id' => $product->id,
                'item_name' => $product->name,
                'quantity' => $quantity,
                'requested_price' => round($requestedPrice, 2),
                'message' => $messages[array_rand($messages)],
                'status' => $status,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ];
            
            // Add quoted price if not pending
            if ($status !== 'pending') {
                $quoteData['quoted_price'] = round($quotedPrice, 2);
            }
            
            $quote = Quote::create($quoteData);
            
            // Add seller response if quote is not pending
            if ($status !== 'pending') {
                $quote->update([
                    'seller_response' => $responses[array_rand($responses)],
                    'responded_at' => now()->subDays(rand(0, 5)),
                ]);
            }
        }

        $this->command->info('Quotes seeded successfully!');
    }
}