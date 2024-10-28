<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class Home extends Component
{

    public $user;

    #[On('closeModal')]
    public function reverUrl(){
        $this->js("history.replaceState({},'','')");
    }

    public function mount($user){
        $this->user = User::whereUsername($user)->with(['followers', 'followings', 'posts'])->firstOrFail();
    }

    public function toggleFollow(){
        abort_unless(auth()->check(), 401);

        auth()->user()->toggleFollow($this->user);
    }

    public function render()
    {
        $this->user = User::whereUsername($this->user->username)->with(['followers', 'followings', 'posts'])->firstOrFail();
        $posts = $this->user->posts()->where('type', 'post')->get();
        return view('livewire.profile.home', ['posts' => $posts]);
    }
}
