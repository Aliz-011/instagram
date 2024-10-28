<div class="max-w-xl mx-auto border-b border-gray-800 pb-2">
    <header class="flex items-center gap-3">
        <x-avatar src="https://github.com/shadcn.png" class="size-10" />
        <div class="grid grid-cols-7 w-full gap-2">
            <div class="col-span-5 flex items-center">
                <a wire:navigate href="{{route('profile.home', $post->user->username)}}"
                    class="font-semibold truncate text-base">{{ $post->user->username }} </a>
                <x-lucide-dot class="size-4 text-slate-600" />
                <span class="font-light text-sm text-gray-300">{{ $post->created_at->diffForHumans() }}</span>
            </div>

            <div class="col-span-2 flex text-right justify-end">
                <button>
                    <x-lucide-ellipsis class="size-5" />
                </button>
            </div>
        </div>
    </header>

    {{-- POST's MEDIAs --}}
    <div>
        <div class="my-2">
            <div class="swiper h-[500px]" x-init="new Swiper($el, {
                        modules: [Navigation, Pagination],
                        pagination: {
                            el: '.swiper-pagination',
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        }})">
                <!-- Additional required wrapper -->
                <ul x-cloak class="swiper-wrapper">
                    @foreach ($post->media as $file)
                    <li class="swiper-slide">
                        @switch($file->mime)
                        @case('video')
                        <x-video source_url="{{$file->url}}" />
                        @break
                        @case('image')
                        <img src="{{$file->url}}" alt="post" class="w-full h-[500px] block object-scale-down" />
                        @break

                        @default

                        @endswitch
                    </li>
                    @endforeach

                </ul>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                @if (count($post->media) > 1)
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev absolute top-1/2 z-10 p-2">
                    <div class="bg-white/60 p-1 rounded-full text-gray-800/70 cursor-pointer">
                        <x-lucide-chevron-left class="size-4" />
                    </div>
                </div>
                <div class="swiper-button-next absolute right-0 top-1/2 z-10 p-2">
                    <div class="bg-white/60 p-1 rounded-full text-gray-800/70 cursor-pointer">
                        <x-lucide-chevron-right class="size-4" />
                    </div>
                </div>
                @endif

                <!-- If we need scrollbar -->
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </div>

    {{-- LIKES & COMMENTS etc. --}}
    <div class="space-y-1">
        <div class="flex gap-4 items-center mt-4">
            @if ($post->isLikedBy(auth()->user()))
            <button wire:click="togglePostLike">
                <x-lucide-heart class="cursor-pointer size-6 fill-rose-500 text-rose-500" />
            </button>
            @else
            <button wire:click="togglePostLike">
                <x-lucide-heart class="cursor-pointer size-6" />
            </button>
            @endif

            @if ($post->allow_commenting)
            <button
                onclick="Livewire.dispatch('openModal',{component:'post.view.modal',arguments:{'post':`{{$post->id}}`}})"
                type="button">
                <x-lucide-message-circle class="cursor-pointer size-6" />
            </button>
            @endif

            <x-lucide-send class="cursor-pointer size-6 rotate-[20deg]" />

            @if ($post->hasBeenFavoritedBy(auth()->user()))
            <button wire:click="toggleBookmark" class="ml-auto">
                <x-lucide-bookmark class="size-6 fill-white text-white" />
            </button>
            @else
            <button wire:click="toggleBookmark" class="ml-auto">
                <x-lucide-bookmark class="size-6" />
            </button>
            @endif
        </div>

        @if (!$post->hide_like_view && $post->totalLikers > 0)
        <p class="font-bold text-base text-slate-100 mb-1 mt-2">{{$post->totalLikers}} likes</p>
        @endif

        <div class="flex items-start gap-2 font-medium">
            <a wire:navigate href="{{route('profile.home', $post->user->username)}}"
                class="font-bold text-base text-white">{{
                $post->user->username }}</a>
            <p class="text-base">
                {{$post->description}}
            </p>
        </div>

        <button
            onclick="Livewire.dispatch('openModal',{component:'post.view.modal',arguments:{'post':`{{$post->id}}`}})"
            class="text-stone-300 text-sm font-medium">View all {{$post->comments->count()}} comments</button>

        @if ($post->allow_commenting)
        @auth
        <ul class="my-2">
            @foreach ($post->comments()->where('user_id', auth()->id())->limit(2)->get() as $comment)
            <li class="grid grid-cols-12 text-sm items-center" wire:key="{{$comment->id}}">
                <span class="font-bold col-span-1 mb-auto">{{ auth()->user()->username}}</span>
                <span class="col-span-10">{{ $comment->body }}</span>
                @if ($comment->isLikedBy(auth()->user()))
                <button wire:click="toggleCommentLike(`{{$comment->id}}`)"
                    class="col-span-1 mb-auto flex justify-end pr-px">
                    <x-lucide-heart class="size-3 fill-rose-500 text-rose-500" />
                </button>
                @else
                <button wire:click="toggleCommentLike(`{{$comment->id}}`)"
                    class="col-span-1 mb-auto flex justify-end pr-px">
                    <x-lucide-heart class="size-3" />
                </button>
                @endif
            </li>
            @endforeach
        </ul>
        @endauth

        <form wire:key="{{time()}}" @submit.prevent="$wire.addComment" class="grid grid-cols-12 items-center w-full"
            x-data="{body: $wire.entangle('body')}">
            @csrf

            <input x-model="body" type="text" placeholder="Add a comment"
                class="border-0 col-span-10 placeholder:text-sm focus:outline-none bg-inherit px-0 rounded-lg hover:ring-0 focus:ring-0 placeholder:text-stone-500">
            <div class="col-span-1 ml-auto flex justify-end text-right">
                <button x-cloak x-show="body.length > 0" class="text-sm font-semibold flex justify-end text-blue-500">
                    Post
                </button>
            </div>

            <span class="col-span-1 ml-auto cursor-pointer">
                <x-lucide-smile class="size-5" />
            </span>
        </form>
        @endif
    </div>
</div>