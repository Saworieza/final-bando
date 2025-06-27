<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@bando.test',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        $seller = User::create([
            'name' => 'Seller',
            'email' => 'seller@bando.test',
            'password' => bcrypt('password'),
        ]);
        $seller->assignRole('Seller');

        // Assume this user exists and is a Seller
        // $seller = User::where('email', 'seller@bando.test')->first();

        // if ($seller) {
        //     Product::factory()->count(5)->create([
        //         'user_id' => $seller->id,
        //     ]);
        // }

        $buyer = User::create([
            'name' => 'Buyer',
            'email' => 'buyer@bando.test',
            'password' => bcrypt('password'),
        ]);
        $buyer->assignRole('Buyer');

        $support = User::create([
            'name' => 'Support Agent',
            'email' => 'support@bando.test',
            'password' => bcrypt('password'),
        ]);
        $support->assignRole('Support Agent');
    }
}
