@props(['user'])
<div class="max-w-3xl mx-auto">
    {{-- Mobile only header --}}
    <header class="items-center py-2 px-2 border-b border-gray-800 lg:hidden grid grid-cols-12">
        <button onclick="history.back()" class="col-span-2">
            <x-lucide-chevron-left class="size-6" />
        </button>

        {{--profile username --}}
        <div class="col-span-8 ">
            <h2 class="font-bold mx-auto truncate">
                {{$user->username}}
            </h2>
        </div>

        <div class="col-span-2 flex justify-end ">
            {{-- Guest options button --}}
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-three-dots" viewBox="0 0 16 16">
                    <path
                        d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                </svg>
            </button>
        </div>
    </header>

    {{-- Details --}}
    <section class="grid grid-cols-12 p-2 my-5 lg:my-12 ">
        {{-- Avatar --}}
        <div class="col-span-4 flex items-center">
            <x-avatar src="https://source.unsplash.com/500x500?face" class="size-20 lg:size-44 m-auto" />
        </div>

        <aside class="col-span-8 lg:max-w-2xl lg:mx-auto flex flex-col gap-5">
            {{-- Actions --}}
            <div class="grid grid-cols-12 items-center gap-3">
                <span class="col-span-6 text-2xl lg:col-span-5 truncate font-bold">
                    {{$user->username}}
                </span>

                @auth
                @if (auth()->id() == $user->id)
                <div class="col-span-6 lg:col-span-6">
                    {{-- Send message button --}}
                    <button type="button"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide transition-colors duration-100 rounded-md text-slate-50 bg-slate-800 focus:ring-2 focus:ring-offset-2 focus:ring-slate-800/80 hover:text-slate-100 hover:bg-slate-800/80">
                        Edit profile
                    </button>
                </div>

                <button class="col-span-1 hidden lg:flex">
                    <x-lucide-settings class="size-6" />
                </button>
                @else
                <div class="col-span-12 lg:col-span-6 grid grid-cols-2 gap-3 ">
                    {{-- check following status --}}
                    @if (auth()->user()->isFollowing($user))
                    <button wire:click="toggleFollow" type="button"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide transition-colors duration-100 rounded-md text-neutral-500 bg-neutral-50 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-100 hover:text-neutral-600 hover:bg-neutral-100">
                        Following
                    </button>
                    @else


                    <button wire:click="toggleFollow" type="button"
                        class="inline-flex justify-center font-bold items-center rounded-lg text-sm p-1.5 px-2 transition bg-blue-500 text-white ">
                        Follow
                    </button>
                    @endif

                    {{-- Send message button --}}
                    <button wire:click="message({{$user->id}})" type="button"
                        class="inline-flex justify-center font-bold items-center rounded-lg text-sm p-1.5 px-2 transition bg-slate-400/40 hover:bg-slate-400/80">
                        Message
                    </button>

                </div>

                <button class="col-span-1 hidden lg:flex">
                    <x-lucide-ellipsis class="size-6" />
                </button>
                @endif
                @endauth
            </div>

            {{-- following details --}}
            <div class="grid grid-cols-3 w-full gap-2">
                <span class="font-bold" wire:key='{{time()}}'>{{$user->posts->count()}} Posts</span>
                <span class="font-bold">{{$user->followers->count()}} Followers</span>
                <span class="font-bold">{{$user->followings->count()}} following</span>
            </div>

            {{-- profile user's name --}}
            <h4>
                {{$user->name}}
            </h4>
        </aside>
    </section>

    {{-- Tabs --}}
    <section class="border-t border-gray-800">
        <ul class="grid grid-cols-3 gap-4 max-w-sm mx-auto pb-3">
            {{-- Posts --}}
            <li
                class="w-full ps-3 pe-4 py-2 cursor-pointer {{request()->routeIs('profile.home')?'border-t border-gray-500' : ''}}">
                <a wire:navigate class="flex items-center gap-2 py-2" href="{{route('profile.home',$user->username)}}">
                    <x-lucide-grid-2x2 class="size-6" />
                    <h4 class="font-bold capitalize">Posts</h4>
                </a>
            </li>

            {{-- reels --}}
            <li
                class="w-full ps-3 pe-4 py-2 cursor-pointer {{request()->routeIs('profile.reels')?'border-t border-gray-500' : ''}} ">
                <a wire:navigate class="flex items-center gap-2 py-2" href="{{route('profile.reels',$user->username)}}">
                    <span>
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
                    </span>

                    <h4 class="font-bold capitalize">Reels</h4>
                </a>
            </li>

            @auth
            @if ( auth()->user()->id === $user->id)
            {{-- Saved --}}
            <li
                class="w-full ps-3 pe-4 py-2 cursor-pointer {{request()->routeIs('profile.saved')?'border-t border-gray-500':''}}">
                <a wire:navigate class="flex items-center gap-2 py-2" href="{{route('profile.saved',$user->username)}}">
                    <x-lucide-bookmark class="size-6" />
                    <h4 class="font-bold capitalize">Saved</h4>
                </a>
            </li>
            @endif
            @endauth
        </ul>
    </section>

    <main class="my-7">
        {{$slot}}
    </main>

</div>