<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Discussion;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Topic::insert([
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
            ],
            [
                'name' => 'Vue',
                'slug' => 'vue',
            ]
        ]);
        Discussion::insert([
            [
                'title' => 'How to do',
                'slug' => 'how-to-do',
                'user_id' => User::query()->inRandomOrder()->value('id'),
                'topic_id' => Topic::query()->inRandomOrder()->value('id'),
            ],
            [
                'title' => 'Guess what',
                'slug' => 'guess-what',
                'user_id' => User::query()->inRandomOrder()->value('id'),
                'topic_id' => Topic::query()->inRandomOrder()->value('id'),
            ],
            [
                'title' => 'Today is saturday',
                'slug' => 'today-is-saturday',
                'user_id' => User::query()->inRandomOrder()->value('id'),
                'topic_id' => Topic::query()->inRandomOrder()->value('id'),
            ]
        ]);
    }
}
