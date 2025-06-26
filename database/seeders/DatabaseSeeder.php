<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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

        //  // Assume this user exists and is a Seller
        // $seller = AdminUserSeeder::where('email', 'seller@bando.test')->first();

        // if ($seller) {
        //     Product::factory()->count(5)->create([
        //         'user_id' => $seller->id,
        //     ]);
        // }
    }
}
