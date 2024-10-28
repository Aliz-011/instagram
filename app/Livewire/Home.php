<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\{Layout, On, Title};
use Livewire\Component;


#[Layout('layouts.app')]
class Home extends Component
{
    public $posts;
    public $canLoadMore;
    public $perPageIncrements = 5;
    public $perPage = 10;

    #[On('closeModal')]
    public function reverUrl(){
        $this->js("history.replaceState({},'','/')");
    }

    #[On('post-created')]
    public function postCreated($id){
        $post = Post::find($id);

        $this->posts = $this->posts->prepend($post);
    }

    public function loadPosts() {
        $this->posts = Post::with(['comments.replies'])->latest()->take($this->perPage)->get();

        $this->canLoadMore = Post::count() > $this->posts->count();
    }

    public function loadMore()  {
        if (!$this->canLoadMore) {
            return null;
        }

        $this->perPage = $this->perPage + $this->perPageIncrements;
        $this->loadPosts();
    }

    public function toggleFollow(User $user){
        abort_unless(auth()->check(), 401);

        auth()->user()->toggleFollow($user);
    }

    public function mount() {
        $this->loadPosts();
    }

    public function render()
    {
        $suggestedUsers = User::limit(5)->get();
        return view('livewire.home', ['suggestedUsers' => $suggestedUsers]);
    }
}
