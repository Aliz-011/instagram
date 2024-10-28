<?php

namespace App\Livewire\Post;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Post;

class Item extends Component
{
    public Post $post;
    public $body = '';

    public function addComment(){
        $this->validate(['body' => 'required']);

        Comment::create([
            'body' => $this->body,
            'commentable_id' => $this->post->id,
            'commentable_type' => Post::class,
            'user_id' => auth()->user()->id
        ]);

        $this->reset(['body']);
    }

    public function togglePostLike() {
         abort_unless(auth()->check(), 401);

         auth()->user()->toggleLike($this->post);
    }

    public function toggleCommentLike(Comment $comment) {
         abort_unless(auth()->check(), 401);

         auth()->user()->toggleLike($comment);
    }

    // Favorite table but we named the function `bookmark` instead 😀
    public function toggleBookmark() {
        abort_unless(auth()->check(), 401);
        auth()->user()->toggleFavorite($this->post);
    }
    
    public function render()
    {
        return view('livewire.post.item');
    }
}
