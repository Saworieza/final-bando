<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\BlogCategory;
use App\Models\Quote; // Add this import at the top

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
            ProductSeeder::class,
            QuoteSeeder::class,
        ]);

    }
}
