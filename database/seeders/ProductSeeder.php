<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ProductSeeder extends Seeder
{
    public function run()
    {

        // Ensure Seller role exists
        Role::firstOrCreate(['name' => 'Seller']);

        // Get or create seller users
        $sellers = User::role('Seller')->get();
        
        if ($sellers->isEmpty()) {
            // Create 5 seller users if none exist
            $sellers = User::factory()
                ->count(5)
                ->create()
                ->each(function ($user) {
                    $user->assignRole('Seller');
                });
        }

        // Sample products data
        $products = [
            [
                'name' => 'Industrial Conveyor Belt',
                'description' => 'Heavy-duty conveyor belt for manufacturing',
                'price' => 1250.99,
                'image' => 'products/conveyor-belt.jpg',
                'user_id' => $sellers->random()->id
            ],
            [
                'name' => 'Hydraulic Pump',
                'description' => 'High-pressure hydraulic pump system',
                'price' => 899.50,
                'image' => 'products/hydraulic-pump.jpg',
                'user_id' => $sellers->random()->id
            ],
            [
                'name' => 'Safety Gloves (Pack of 10)',
                'description' => 'Industrial-grade safety gloves',
                'price' => 45.00,
                'image' => 'products/safety-gloves.jpg',
                'user_id' => $sellers->random()->id
            ],
            [
                'name' => 'Steel Bearings',
                'description' => 'Premium quality steel ball bearings',
                'price' => 29.99,
                'image' => null, // Testing nullable image
                'user_id' => $sellers->random()->id
            ],
            [
                'name' => 'Electric Motor 5HP',
                'description' => 'Industrial electric motor 5 horsepower',
                'price' => 499.95,
                'image' => 'products/electric-motor.jpg',
                'user_id' => $sellers->random()->id
            ],
        ];

        // Create sample products
        foreach ($products as $product) {
            Product::create($product);
        }

        // Create additional random products (all assigned to sellers)
        Product::factory()
            ->count(15)
            ->create([
                'user_id' => function () use ($sellers) {
                    return $sellers->random()->id;
                }
            ]);
    }
}