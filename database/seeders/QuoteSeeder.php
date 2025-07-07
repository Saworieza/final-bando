<?php 
// database/seeders/QuoteSeeder.php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteResponse;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Faker\Factory as FakerFactory;

class QuoteSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        // Ensure we have the necessary roles
        $requiredRoles = ['Admin', 'Seller', 'Buyer'];
        foreach ($requiredRoles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Get or create test users if they don't exist
        $admin = User::firstOrCreate(
            ['email' => 'admin@bando.test'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        )->assignRole('Admin');

        $seller = User::firstOrCreate(
            ['email' => 'seller@bando.test'],
            [
                'name' => 'Seller',
                'password' => bcrypt('password'),
            ]
        )->assignRole('Seller');

        $buyer = User::firstOrCreate(
            ['email' => 'buyer@bando.test'],
            [
                'name' => 'Buyer',
                'password' => bcrypt('password'),
            ]
        )->assignRole('Buyer');

        // Create additional sellers and buyers if needed
        if (User::role('Seller')->count() < 5) {
            User::factory()->count(4)->create()->each->assignRole('Seller');
        }

        if (User::role('Buyer')->count() < 10) {
            User::factory()->count(9)->create()->each->assignRole('Buyer');
        }

        // Create quotes - 30 total with mixed statuses
        $quotes = Quote::factory()->count(30)->create();

        // Create responses for accepted/completed quotes
        $quotes->each(function ($quote) use ($faker) {
            if ($quote->status !== 'pending' && $faker->boolean(80)) {
                QuoteResponse::factory()->count($faker->numberBetween(1, 3))->create([
                    'quote_id' => $quote->id,
                    'seller_id' => $quote->product->user_id,
                ]);
            }
        });

        // Mark some responded quotes as completed
        Quote::has('responses')->inRandomOrder()->take(5)->update(['status' => 'completed']);

        // Create a specific test quote for the test buyer
        Quote::factory()->create([
            'product_id' => Product::first()->id,
            'buyer_id' => $buyer->id, // Now using the properly defined $buyer variable
            'company_name' => 'Test Company',
            'contact_name' => 'Test Buyer',
            'email' => 'buyer@bando.test',
            'quantity' => 5,
            'status' => 'pending',
        ]);
    }
}