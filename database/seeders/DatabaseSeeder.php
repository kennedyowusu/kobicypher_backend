<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    // Seed posts and associate tags using the attach method
        // Post::factory(10)->create()->each(function ($post) {
        //     $post->tags()->attach(Tag::inRandomOrder()->limit(3)->pluck('id'));
        // });
        // WithoutModelEvents::class,
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
        ]);
    }
}
