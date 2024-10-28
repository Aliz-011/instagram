<div class="lg:px-32 overflow-hidden my-auto h-full flex flex-col">
    <ul class="flex flex-col my-auto gap-y-6 snap-y snap-mandatory overflow-x-hidden h-[calc(100vh_-_1rem)]">
        @foreach ($posts as $post)

        @php
        $cover = $post->media()->first();
        @endphp
        <li
            class="h-[calc(100vh_-_5rem)] max-w-lg m-auto w-full cursor-pointer relative rounded-lg group shrink-0 snap-center snap-always grid grid-cols-12 gap-8">
            <div class="col-span-11 bg-black">
                <x-video controls :cover="false" source_url="{{$cover->url}}" />
            </div>

            <div class="col-span-1 flex flex-col gap-y-4 items-center justify-end mb-8">
                <div class="flex flex-col gap-y-1 items-center">
                    @if ($post->isLikedBy(auth()->user()))
                    <button wire:click="togglePostLike(`{{$post->id}}`)">
                        <x-lucide-heart class="cursor-pointer size-7 fill-rose-500 text-rose-500" />
                    </button>
                    @else
                    <button wire:click="togglePostLike(`{{$post->id}}`)">
                        <x-lucide-heart class="cursor-pointer size-7" />
                    </button>
                    @endif

                    <h6 class="text-sm">{{ $post->likers->count() }}</h6>
                </div>


                @if ($post->allow_commenting)
                <div class="flex flex-col gap-y-1 items-center">
                    <button
                        onclick="Livewire.dispatch('openModal',{component:'post.view.modal',arguments:{'post':`{{$post->id}}`}})"
                        type="button">
                        <x-lucide-message-circle class="cursor-pointer size-7 -rotate-90" />
                    </button>
                    <h6 class="text-sm">{{ $post->comments->count() }}</h6>
                </div>
                @endif

                <x-lucide-send class="cursor-pointer size-7 rotate-12" />

                @if ($post->hasBeenFavoritedBy(auth()->user()))
                <button wire:click="toggleBookmark(`{{$post->id}}`)" class="-ml-px">
                    <x-lucide-bookmark class="size-7 fill-white text-white" />
                </button>
                @else
                <button wire:click="toggleBookmark(`{{$post->id}}`)" class="-ml-px">
                    <x-lucide-bookmark class="size-7" />
                </button>
                @endif
            </div>
        </li>
        @endforeach
    </ul>
</div>