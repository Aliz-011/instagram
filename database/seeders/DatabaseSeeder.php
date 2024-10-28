<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // \App\Models\Post::factory(25)->hasComments(rand(1, 30))->create(['type' => 'post']);
        \App\Models\Post::factory(5)->hasComments(rand(4, 8))->create(['type' => 'reel']);

        // \App\Models\Comment::limit(5)->each(function ($comment){
        //     $comment::factory(rand(1, 10))->isReply($comment->commentable)->create(['parent_id' => $comment->id]);
        // });

        \App\Models\Post::factory()->hasComments(rand(1, 30))->create(['type' => 'post']);
        $post = \App\Models\Post::factory()->hasComments(1)->create(['type' => 'post']);

        $parentComment = $post->comments->first();
        for ($i=0; $i < 10; $i++) { 
            $nestedComments = \App\Models\Comment::factory()->isReply($parentComment->commentable)->create(['parent_id' => $parentComment->id]);
            $parentComment = $nestedComments;
        }
    }
}
