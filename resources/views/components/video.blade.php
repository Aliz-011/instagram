@props(['source_url' => 'https://cdn.devdojo.com/pines/videos/coast.mp4', 'controls' => true, 'cover' => false])

<div x-data="{playing: false, muted: false}" class="relative size-full m-auto" @click.outside="$refs.player.pause()"
    x-intersect:leave="$refs.player.pause()">
    <video x-ref="player" @play="playing = true" @pause="playing = false"
        class="size-full max-h-[800px] m-auto {{$cover ? 'object-cover' : ''}}">
        <source src="{{$source_url}}" type="video/mp4">
        your browser does not support HTML5 video
    </video>

    @if ($controls)
    <div x-cloak x-show="!playing" @click="$refs.player.play()"
        class="absolute z-10 inset-0 flex items-center justify-center size-full cursor-pointer">
        <x-lucide-play class="size-16 fill-white text-white" />
    </div>

    <div x-show="playing" @click="$refs.player.pause()"
        class="absolute z-10 inset-0 flex items-center justify-center size-full cursor-pointer">
        <x-lucide-pause class="size-16 fill-white text-white invisible" />
    </div>

    <div class="absolute z-20 bottom-2 right-2 m-4 bg-gray-900 text-white p-1 cursor-pointer rounded-lg">
        <x-lucide-volume-2 x-cloak x-show="!muted" @click="$refs.player.muted = true; muted = true" class="size-4" />
        <x-lucide-volume-x x-show="muted" @click="$refs.player.muted = false; muted = false" class="size-4" />
    </div>
    @endif

</div>