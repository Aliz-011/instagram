<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class Explore extends Component
{
    #[On('closeModal')]
    public function reverUrl(){
        $this->js("history.replaceState({},'','/explore')");
    }
    
    public function render()
    {
        $posts = Post::limit(20)->inRandomOrder()->get();
        return view('livewire.explore', ['posts' => $posts]);
    }
}
