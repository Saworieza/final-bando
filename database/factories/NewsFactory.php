<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'slug' => Str::slug($this->faker->sentence()),
            'content' => $this->faker->paragraphs(5, true),
            'user_id' => 1, // Default to admin, will be overridden in seeder
            'category_id' => 1, // Default to first category
            'is_published' => true,
        ];
    }
}