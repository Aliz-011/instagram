<div class="bg-white lg:h-[500px] flex flex-col border gap-y-4 px-5">
    <div class="w-full py-2 border-b">
        <div class="flex justify-between">
            <button wire:click="$dispatch('closeModal')" class="font-bold focus:outline-none focus:ring-0">
                <x-lucide-x class="size-4 text-black" />
            </button>

            <div class="text-lg font-bold text-black">
                Create new post
            </div>

            <button @disabled(count($media)===0) wire:loading.attr="disabled" wire:click="submit"
                class="font-bold text-blue-500">
                Share
            </button>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-3 size-full overflow-hidden">
        <div class="lg:col-span-7 m-auto items-center w-full overflow-scroll">
            @if (count($media) === 0)
            <label for="uploadFile" class="m-auto max-w-fit flex flex-col gap-3 cursor-pointer">
                <input wire:model="media" type="file" multiple accept=".jpg,.png,.jpeg" id="uploadFile" class="sr-only">

                <div class="m-auto">
                    <x-lucide-image class="size-12" />
                </div>
                <span class="bg-blue-500 text-white rounded-lg px-4 text-sm py-2">Upload file</span>
                <div wire:loading wire:target="photo">Uploading...</div>
            </label>
            @else
            <div class="flex overflow-x-scroll w-[500px] h-96 snap-x snap-mandatory gap-2 px-2">
                @foreach ($media as $key => $file)
                <div class="size-full shrink-0 snap-always snap-center">
                    @if (strpos($file->getMimeType(), 'image') !== false)
                    <img src="{{$file->temporaryUrl()}}" alt="" class="size-full object-contain">
                    @elseif (strpos($file->getMimeType(), 'video') !== false)
                    <x-video source_url="{{$file->temporaryUrl()}}" />
                    @endif
                </div>
                @endforeach
            </div>
            @endif

        </div>

        <div class="lg:col-span-5 h-full border-l p-3 flex flex-col gap-4 overflow-hidden overflow-y-scroll">
            <div class="flex items-center gap-2">
                <x-avatar class="size-6" />
                <h5 class="font-bold text-black">{{ auth()->user()->username }}</h5>
            </div>

            <div>
                <textarea wire:model="description" placeholder="Add a caption"
                    class="border-0 focus:border-0 px-0 rounded-lg bg-white text-black h-32 focus:outline-none focus:ring-0"></textarea>
            </div>

            <div class="w-full items-center">
                <input wire:model="location" type="text" placeholder="Add a location"
                    class="border-0 focus:border-0 px-0 rounded-lg bg-white text-black focus:outline-none focus:ring-0">
            </div>

            <div>
                <h6 class="font-medium text-base text-gray-700">Advanced settings</h6>

                <ul class="space-y-4">
                    <li>
                        <div class="flex items-center gap-3 justify-between">
                            <span class="text-sm text-black">Hide like and view counts for this
                                post</span>

                            <label class="inline-flex items-center cursor-pointer">
                                <input wire:model="hide_like_view" type="checkbox" value="" class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>

                            </label>

                        </div>
                    </li>
                    <li>
                        <div class="flex items-center gap-3 justify-between">
                            <span class="text-sm text-black">Allow commenting</span>

                            <label class="inline-flex items-center cursor-pointer">
                                <input wire:model="allow_commenting" type="checkbox" value="" class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>
                            </label>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>