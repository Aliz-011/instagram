<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

use Livewire\Component;

#[Layout('layouts.app')]
class Reels extends Component
{
    #[On('closeModal')]
    public function reverUrl(){
        $this->js("history.replaceState({},'','/reels')");
    }

    public function togglePostLike(Post $post) {
        abort_unless(auth()->check(), 401);

        auth()->user()->toggleLike($post);
   }

    // Favorite table but we named the function `bookmark` instead 😀
    public function toggleBookmark(Post $post) {
        abort_unless(auth()->check(), 401);
        
        auth()->user()->toggleFavorite($post);
    }
    
    public function render()
    {
        $posts = Post::where('type', 'reel')->get();
        return view('livewire.reels', ['posts' => $posts]);
    }
}
