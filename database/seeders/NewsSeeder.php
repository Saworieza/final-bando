<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsMedia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    public function run()
    {
        // SQLite-compatible data cleanup
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
            NewsMedia::truncate();
            News::truncate();
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            NewsMedia::truncate();
            News::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Get role-specific users
        $admin = User::role('Admin')->first();
        $sellers = User::role('Seller')->get();

        if (!$admin || $sellers->isEmpty()) {
            throw new \Exception('Required users with roles not found. Seed users first.');
        }

        // Create admin news (always published)
        for ($i = 0; $i < 10; $i++) {
            $title = 'Admin News ' . ($i + 1);
            $news = News::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . Str::random(6),
                'content' => 'This is admin-created news content. ' . fake()->paragraph(),
                'user_id' => $admin->id,
                'category_id' => rand(1, 5),
                'is_published' => true,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);

            $this->addMediaToNews($news, true);
        }

        // Create seller news (some unpublished)
        foreach ($sellers as $seller) {
            for ($i = 0; $i < 3; $i++) {
                $title = 'Seller News by ' . $seller->name . ' ' . ($i + 1);
                $news = News::create([
                    'title' => $title,
                    'slug' => Str::slug($title) . '-' . Str::random(6),
                    'content' => 'This is seller-created news content. ' . fake()->paragraph(),
                    'user_id' => $seller->id,
                    'category_id' => rand(1, 5),
                    'is_published' => rand(0, 1),
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);

                $this->addMediaToNews($news, false);
            }
        }
    }

    protected function addMediaToNews($news, $isAdmin)
    {
        // Add 1-3 images
        $imageCount = rand(1, 3);
        for ($i = 0; $i < $imageCount; $i++) {
            NewsMedia::create([
                'news_id' => $news->id,
                'file_path' => 'news/images/sample-' . rand(1, 5) . '.jpg',
                'file_type' => 'image',
                'original_name' => 'sample-image-' . ($i + 1) . '.jpg',
                'created_at' => $news->created_at,
            ]);
        }

        // Admins always get files, sellers have 50% chance
        if ($isAdmin || rand(0, 1)) {
            NewsMedia::create([
                'news_id' => $news->id,
                'file_path' => 'news/files/sample-document.pdf',
                'file_type' => 'file',
                'original_name' => 'sample-document.pdf',
                'created_at' => $news->created_at,
            ]);
        }
    }
}