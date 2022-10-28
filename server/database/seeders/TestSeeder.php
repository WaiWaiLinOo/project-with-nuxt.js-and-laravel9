<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x <= 5; $x++) {
            Category::create([
                'name' => Str::random(10),
            ]);
        }

        for ($x = 0; $x < 5; $x++) {
            $post = Post::create([
                'user_id' => User::all()->random()->id,
                'image' => fake()->imageUrl(640, 480),
                'title' => fake()->sentence(),
                'body' => fake()->paragraph(),
            ]);
            $post->categories()->sync([$x + 1, $x + 2]);
        }
    }
}
