<div wire:key="{{$reply->id}}" class="flex items-center w-11/12 ml-auto gap-3 py-2">
    <x-avatar src="https://github.com/shadcn.png" class="size-9 mb-auto" />
    <div class="grid grid-cols-7 gap-2 w-full">
        <div class="col-span-6 flex flex-wrap text-sm">
            <div>
                <span class="font-bold mr-2">
                    {{$reply->user->username}}
                </span>
                {{$reply->body}}
            </div>
        </div>

        <div class="col-span-1 flex items-center justify-end my-auto text-right">
            @if ($reply->isLikedBy(auth()->user()))
            <button wire:click="toggleCommentLike(`{{$reply->id}}`)" class="font-bold text-sm ml-auto">
                <x-lucide-heart class="size-3 fill-rose-500 text-rose-500" />
            </button>
            @else
            <button wire:click="toggleCommentLike(`{{$reply->id}}`)" class="font-bold text-sm ml-auto">
                <x-lucide-heart class="size-3" />
            </button>
            @endif
        </div>

        <div class="col-span-7 flex gap-2 text-sm items-center text-gray-200">
            <span>{{ $reply->created_at->diffForHumans() }}</span>
            @if (!$reply->hide_like_view && $reply->totalLikers > 0)
            <span>{{$post->totalLikers}} likes</span>
            @endif
            <button wire:click="setParent(`{{$reply->id}}`)" class="font-semibold">
                Reply
            </button>
        </div>
    </div>
</div>

@if ($reply->replies->count() > 0)
@foreach ($reply->replies as $reply)
@include('livewire.post.view.partials.reply')
@endforeach
@endif