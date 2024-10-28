<div class="my-5 lg:px-36 lg:py-8">
    <ul class="grid grid-cols-3 gap-1">
        @foreach ($posts as $post)
        @php
        $cover = $post->media()->first();
        @endphp

        <li wire:key="{{$post->id}}"
            onclick="Livewire.dispatch('openModal',{component:'post.view.modal',arguments:{'post':`{{$post->id}}`}})"
            class="h-28 sm:h-80 w-full cursor-pointer bg-black relative items-center flex justify-center group">
            {{-- HOVER THEN SHOW LIKE AND COMMENTS --}}
            <div
                class="hidden group-hover:flex transition-all absolute inset-x-0 m-auto z-10 max-w-fit items-center gap-4">
                <div class="flex items-center gap-1 text-white font-bold">
                    <x-lucide-heart class="size-8 fill-white" />
                    {{$post->likers->count()}}
                </div>

                <div class="flex items-center gap-1 text-white font-bold">
                    <x-lucide-message-circle class="size-8 fill-white" />
                    {{$post->likers->count()}}
                </div>


            </div>

            @if ($post->type === 'post' && $post->media->count() > 1)
            <div class="absolute top-4 right-4 z-10">
                <span>
                    <svg class="size-8 text-white fill-white" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M1 9.50006C1 10.3285 1.67157 11.0001 2.5 11.0001H4L4 10.0001H2.5C2.22386 10.0001 2 9.7762 2 9.50006L2 2.50006C2 2.22392 2.22386 2.00006 2.5 2.00006L9.5 2.00006C9.77614 2.00006 10 2.22392 10 2.50006V4.00002H5.5C4.67158 4.00002 4 4.67159 4 5.50002V12.5C4 13.3284 4.67158 14 5.5 14H12.5C13.3284 14 14 13.3284 14 12.5V5.50002C14 4.67159 13.3284 4.00002 12.5 4.00002H11V2.50006C11 1.67163 10.3284 1.00006 9.5 1.00006H2.5C1.67157 1.00006 1 1.67163 1 2.50006V9.50006ZM5 5.50002C5 5.22388 5.22386 5.00002 5.5 5.00002H12.5C12.7761 5.00002 13 5.22388 13 5.50002V12.5C13 12.7762 12.7761 13 12.5 13H5.5C5.22386 13 5 12.7762 5 12.5V5.50002Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </span>
            </div>
            @endif

            @if ($post->type === 'reel')
            <div class="absolute top-4 right-4 z-10 text-white">
                <svg aria-label="Reels" class="size-6" color="#fafafa" fill="#fafafa" height="24" role="img"
                    viewBox="0 0 24 24" width="24">
                    <line fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2" x1="2.049"
                        x2="21.95" y1="7.002" y2="7.002"></line>
                    <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" x1="13.504" x2="16.362" y1="2.001" y2="7.002"></line>
                    <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" x1="7.207" x2="10.002" y1="2.11" y2="7.002"></line>
                    <path
                        d="M2 12.001v3.449c0 2.849.698 4.006 1.606 4.945.94.908 2.098 1.607 4.946 1.607h6.896c2.848 0 4.006-.699 4.946-1.607.908-.939 1.606-2.096 1.606-4.945V8.552c0-2.848-.698-4.006-1.606-4.945C19.454 2.699 18.296 2 15.448 2H8.552c-2.848 0-4.006.699-4.946 1.607C2.698 4.546 2 5.704 2 8.552Z"
                        fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2">
                    </path>
                    <path
                        d="M9.763 17.664a.908.908 0 0 1-.454-.787V11.63a.909.909 0 0 1 1.364-.788l4.545 2.624a.909.909 0 0 1 0 1.575l-4.545 2.624a.91.91 0 0 1-.91 0Z"
                        fill-rule="evenodd"></path>
                </svg>
            </div>
            @endif

            @switch($cover->mime)
            @case('video')
            <x-video :controls="false" cover source_url="{{$cover->url}}" />
            @break
            @case('image')
            <img src="{{$cover->url}}" alt="{{$post->description}}" class="object-cover size-full">
            @break
            @default
            @endswitch
        </li>
        @endforeach
    </ul>
</div>