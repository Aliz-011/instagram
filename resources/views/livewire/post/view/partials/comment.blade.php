<div wire:key="{{$comment->id}}" class="flex items-center gap-3 py-2">
    <x-avatar src="https://github.com/shadcn.png" class="size-9 mb-auto" />
    <div class="grid grid-cols-7 gap-2 w-full">
        <div class="col-span-6 flex flex-wrap text-sm">
            <p>
                <span class="font-bold mr-2">
                    {{$comment->user->username}}
                </span>
                {{$comment->body}}
            </p>
        </div>

        <div class="col-span-1 flex items-center justify-end my-auto text-right">
            @if ($comment->isLikedBy(auth()->user()))
            <button wire:click="toggleCommentLike(`{{$comment->id}}`)" class="font-bold text-sm ml-auto">
                <x-lucide-heart class="size-3 fill-rose-500 text-rose-500" />
            </button>
            @else
            <button wire:click="toggleCommentLike(`{{$comment->id}}`)" class="font-bold text-sm ml-auto">
                <x-lucide-heart class="size-3" />
            </button>
            @endif
        </div>

        <div class="col-span-7 flex gap-2 text-sm items-center text-gray-200">
            <span>{{ $comment->created_at->diffForHumans() }}</span>
            @if (!$comment->hide_like_view && $comment->totalLikers > 0)
            <span>{{$post->totalLikers}} likes</span>
            @endif
            <span wire:click="setParent(`{{$comment->id}}`)" class="font-semibold cursor-pointer">Reply</span>
        </div>
    </div>
</div>