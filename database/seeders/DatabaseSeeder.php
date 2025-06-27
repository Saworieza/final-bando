<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

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
            ['name' => 'Industrial', 'slug' => 'industrail'],
            ['name' => 'Agricultural', 'slug' => 'agricultural'],
            ['name' => 'Conveyor', 'slug' => 'conveyor-belts'],
            ['name' => 'Belt Tools', 'slug' => 'tools'],
        ]);

    }
}
