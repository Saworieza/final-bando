<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

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
