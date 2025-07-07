<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ProductSeeder extends Seeder
{
    protected $sampleImages = [
        'sample-1.png',
        'sample-2.png',
        'sample-3.png',
        'sample-4.png',
        'sample-5.png'
    ];

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

        // Sample products data - now using your sample images
        $products = [
            [
                'name' => 'Industrial Conveyor Belt',
                'description' => 'Heavy-duty conveyor belt for manufacturing',
                'price' => 1250.99,
                'image' => 'images/'.$this->sampleImages[array_rand($this->sampleImages)],
                'user_id' => $sellers->random()->id,
                'category_id' => 1 // Industrial
            ],
            [
                'name' => 'Hydraulic Pump',
                'description' => 'High-pressure hydraulic pump system',
                'price' => 899.50,
                'image' => 'images/'.$this->sampleImages[array_rand($this->sampleImages)],
                'user_id' => $sellers->random()->id,
                'category_id' => 2 // Automotive
            ],
            [
                'name' => 'Safety Gloves (Pack of 10)',
                'description' => 'Industrial-grade safety gloves',
                'price' => 45.00,
                'image' => 'images/'.$this->sampleImages[array_rand($this->sampleImages)],
                'user_id' => $sellers->random()->id,
                'category_id' => 3 // Agricultural
            ],
            [
                'name' => 'Steel Bearings',
                'description' => 'Premium quality steel ball bearings',
                'price' => 29.99,
                'image' => null, // Testing nullable image
                'user_id' => $sellers->random()->id,
                'category_id' => 4 // Conveyor
            ],
            [
                'name' => 'Electric Motor 5HP',
                'description' => 'Industrial electric motor 5 horsepower',
                'price' => 499.95,
                'image' => 'images/'.$this->sampleImages[array_rand($this->sampleImages)],
                'user_id' => $sellers->random()->id,
                'category_id' => 5 // Belt Tools
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