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
        Category::insert([
            ['name' => 'Automotive', 'slug' => 'automotive'],
            ['name' => 'Industrial', 'slug' => 'industrial'],
            ['name' => 'Agricultural', 'slug' => 'agricultural'],
            ['name' => 'Conveyor', 'slug' => 'conveyor-belts'],
            ['name' => 'Belt Tools', 'slug' => 'tools'],
        ]);
        
        // Run the role and user seeders
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
            NewsSeeder::class,
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
