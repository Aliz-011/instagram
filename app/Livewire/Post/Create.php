<?php

namespace App\Livewire\Post;

use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Storage;

class Create extends ModalComponent
{

    use WithFileUploads;

    public $media = [];
    public $description;
    public $location;
    public $hide_like_view = false;
    public $allow_commenting = true;

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function submit() {
        $this->validate([
            'media.*' => 'required|file|mimes:png,jpg,mp4,jpeg,mov|max:100000',
            'allow_commenting' => 'boolean',
            'hide_like_view' => 'boolean',
        ]);

        $type = $this->getPostType($this->media);

        $post = auth()->user()->posts()->create([
            'description' => $this->description,
            'location' => $this->location,
            'allow_commenting' => $this->allow_commenting,
            'hide_like_view' => $this->hide_like_view,
            'type' => $type
        ]);

        foreach ($this->media as $key => $media) {
            $mime = $this->getMime($media);

            $path = $media->store('media', 'public');

            $url = url(Storage::url($path));

            \App\Models\Media::create([
                'url' => $url,
                'mime' => $mime,
                'mediable_id' => $post->id,
                'mediable_type' => \App\Models\Post::class
            ]);

            $this->reset();
            $this->dispatch('close');

            $this->dispatch('post-created', $post->id);
        }
    }

    public function getMime($media) {
        if (str()->contains($media->getMimeType(), 'video')) {
            return 'video';
        }

        return 'image';
    }

    public function getPostType($media){
        if (count($media) === 1 && str()->contains($media[0]->getMimeType(), 'video')) {
            return 'reel';
        }

        return 'post';
    }

    public function render()
    {
        return view('livewire.post.create');
    }
}
