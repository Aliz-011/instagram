<x-profile-layout :user="$user">
    <ul class="grid grid-cols-3 gap-4">
        @foreach ($posts as $post)

        @php
        $cover = $post->media()->first();
        @endphp

        <li onclick="Livewire.dispatch('openModal',{component:'post.view.modal',arguments:{'post':`{{$post->id}}`}})"
            class="h-32 md:h-72 border border-gray-800 w-full cursor-pointer" wire:key="{{$post->id}}">
            @switch($cover->mime)
            @case('video')
            <x-video source_url="{{$cover->url}}" />
            @break
            @case('image')
            <img src="{{$cover->url}}" alt="{{$post->description}}" class="object-cover size-full">
            @break
            @default
            @endswitch
        </li>
        @endforeach
    </ul>
</x-profile-layout>