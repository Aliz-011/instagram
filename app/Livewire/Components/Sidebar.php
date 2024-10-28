<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Component;

class Sidebar extends Component
{
    public $drawer = false;
    public $shrink = false;
    public $showSearch = false;
    public $showNotifications = false;

    public $search;
    public $results;

    public function updating($property){
        if (strlen($this->search) > 1) {
            $this->results = User::where('username', 'like', '%'.$this->search.'%')
                ->orWhere('name', 'like', '%'.$this->search.'%')
                ->limit(10)
                ->get();
        } else {
            $this->results = collect();
        }
    }

    public function updatedQuery()
    {
        
    }

    public function toggleDrawer(){
        $this->drawer = !$this->drawer;
        if (!$this->drawer) {
            $this->search = '';
            $this->drawer = false;
            $this->showSearch = false;
            $this->showNotifications = false;
        } else{
            $this->drawer = true;
            $this->showSearch = true;
            $this->showNotifications = false;
        }
    }

    public function closeDrawer(){
        $this->search = '';
        $this->drawer = false;
        $this->showSearch = false;
        $this->showNotifications = false;
    }

    public function render()
    {
        return view('livewire.components.sidebar');
    }
}
