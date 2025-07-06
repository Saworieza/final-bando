<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\BlogCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the role and user seeders
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
        ]);

        Category::insert([
            ['name' => 'Automotive', 'slug' => 'automotive'],
            ['name' => 'Industrial', 'slug' => 'industrial'],
            ['name' => 'Agricultural', 'slug' => 'agricultural'],
            ['name' => 'Conveyor', 'slug' => 'conveyor-belts'],
            ['name' => 'Belt Tools', 'slug' => 'tools'],
        ]);

        BlogCategory::insert([
            ['name' => 'Automotive Literature', 'slug' => 'automotive-literature'],
            ['name' => 'Industrial', 'slug' => 'industrial-literature'],
            ['name' => 'Agricultural', 'slug' => 'agricultural-literature'],
            ['name' => 'Conveyor', 'slug' => 'conveyor-literature'],
            ['name' => 'Belt Tools', 'slug' => 'tools-literature'],
        ]);

        Quote::factory()->create([
            'product_id' => 1,
            'buyer_id' => 2,
            'seller_id' => 3,
            'item' => '10 boxes of safety gloves',
            'quote_date' => now(),
            'status' => 'pending',
        ]);

    }
}
