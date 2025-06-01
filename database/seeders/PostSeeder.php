<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        for ($i = 0; $i < 20; $i++) {
            Post::create([
                'title' => fake()->sentence(6),
                'content' => fake()->paragraphs(3, true),
                'author_id' => $users->random()->id,
                'status' => fake()->numberBetween(0, 2),
                'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
