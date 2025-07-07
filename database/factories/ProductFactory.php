<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory
{
    protected $sampleImages = [
        'sample-1.png',
        'sample-2.png',
        'sample-3.png',
        'sample-4.png',
        'sample-5.png'
    ];

    public function definition()
    {
        $seller = User::role('Seller')->inRandomOrder()->first() ?? 
                 User::factory()->create()->assignRole('Seller');

        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->boolean(80) ? $this->faker->paragraph : null,
            'price' => $this->faker->randomFloat(2, 10, 5000),
            'image' => $this->faker->boolean(70) 
                ? 'news/images/'.$this->faker->randomElement($this->sampleImages) 
                : null,
            'category_id' => $this->faker->numberBetween(1, 5),
            'user_id' => $seller->id,
        ];
    }
}