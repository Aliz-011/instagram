<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'description' => fake()->sentence(),
            'location' => fake()->city(),
            'allow_commenting' => fake()->boolean(),
            'hide_like_view' => fake()->boolean(),
            'type' => 'post',
        ];
    }

    public function configure(): static {
        return $this->afterCreating(function (Post $post) {
            if ($post->type === 'reel') {
                Media::factory()->reel()->create([
                    'mediable_type' => get_class($post),
                    'mediable_id' => $post->id
                ]); 
                return;
            }

            Media::factory()->reel()->create([
                'mediable_type' => get_class($post),
                'mediable_id' => $post->id
            ]); 
        });
    }
}
