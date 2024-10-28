<div class="grid lg:grid-cols-12 gap-3 size-full overflow-hidden">
    <div class="lg:col-span-7 m-auto items-center w-full overflow-scroll">
        <div
            class="relative hidden lg:flex overflow-x-scroll overscroll-contain w-full snap-x snap-mandatory gap-2 px-2">
            @foreach ($post->media as $key => $file)
            <div class="size-full shrink-0 snap-always snap-center">
                @switch($file->mime)
                @case('video')
                <x-video source_url="{{$file->url}}" />
                @break
                @case('image')
                <img src="{{$file->url}}" alt="{{$post->user->username}}'s post"
                    class="size-full block object-scale-down">
                @break
                @default
                @endswitch
            </div>
            @endforeach
        </div>
    </div>

    <div class="lg:col-span-5 h-full scrollbar-hide relative flex flex-col gap-4 overflow-hidden overflow-y-scroll">
        <div class="flex items-center gap-3 border-b border-stone-700 py-4 sticky top-0 bg-black z-10">
            <x-avatar src="https://github.com/shadcn.png" class="size-9" />

            <div class="grid grid-cols-7 w-full gap-2">
                <h5 class="col-span-5 truncate text-sm text-white">
                    {{$post->user->username}}
                </h5>

                <div class="flex col-span-2 text-right justify-end">
                    <button class="ml-auto text-gray-300" type="button" wire:click="$dispatch('closeModal')">
                        <x-lucide-x class="size-5" />
                    </button>
                </div>
            </div>
        </div>

        @if ($comments)
        @foreach ($comments as $comment)
        <div class="flex flex-col gap-2 text-white">
            @include('livewire.post.view.partials.comment')

            {{-- Comment's replies --}}
            @if ($comment->replies)
            @foreach ($comment->replies as $reply)
            @include('livewire.post.view.partials.reply')
            @endforeach
            @endif

        </div>
        @endforeach
        @else
        <div class="flex items-center justify-center">
            <span class="text-white font-bold text-lg">No comments here</span>
        </div>
        @endif

        <div class="mt-auto sticky border-t border-gray-700 bottom-0 z-10 bg-black">
            <div class="flex gap-4 items-center my-4 text-slate-100">
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
                <x-lucide-message-circle class="size-6" />
                @endif
                <x-lucide-send class="size-6" />
                <x-lucide-bookmark class="size-6 ml-auto" />
            </div>

            {{-- LIKES COUNTER --}}
            @if (!$post->hide_like_view && $post->totalLikers > 0)
            <p class="font-bold text-base text-slate-100 mb-1">{{$post->totalLikers}} likes</p>
            @endif

            <div class="flex text-sm gap-2 font-medium text-white">
                <p>
                    <strong class="font-bold text-base">{{ $post->user->username }}</strong> {{$post->description
                    }}
                </p>
            </div>

            <button class="text-slate-300 text-xs font-medium">{{$post->created_at->diffForHumans()}}</button>

            {{-- COMMENT FORM --}}
            @if ($post->allow_commenting)
            <form class="grid grid-cols-12 items-center w-full py-4" x-data="{body: $wire.entangle('body')}"
                @submit.prevent="$wire.addComment">
                @csrf

                <input x-model="body" type="text" placeholder="Leave a comment"
                    class="border-0 col-span-10 placeholder:text-sm focus:outline-none bg-inherit px-0 rounded-lg hover:ring-0 focus:ring-0">
                <div class="col-span-1 ml-auto flex justify-end text-right">
                    <button x-cloak x-show="body.length > 0"
                        class="text-sm font-semibold flex justify-end text-blue-500">
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
</div>