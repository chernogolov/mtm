@props(['data', 'value', 'field', 'name'])
<div
        x-data="{ 'showModal': false, imgModalSrc : ''}"
        @keydown.escape="showModal = false"
>
    <!-- Modal -->
    <div
            class="fixed inset-0 z-30 flex items-center justify-center overflow-auto bg-black bg-opacity-50"
            x-show="showModal"
    >
        <!-- Modal inner -->
        <div
                class="max-w-5xl  mx-auto text-left rounded shadow-lg relative"
                @click.away="showModal = false"
                x-transition:enter="motion-safe:ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
        >
            <!-- Title / Close-->
            <div class="absolute right-2 top-2">
                <button type="button" class="z-50 cursor-pointer rounded-sm bg-white" @click="showModal = false">
                    <svg class="hover:shadow-lg text-gray-500 hover:text-gray-800" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <img :alt="imgModalSrc" class="object-contain h-1/2-screen" :src="imgModalSrc">
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-data="" id="{{$name}}">
        @php $gallery = json_decode($value) @endphp
        @if(is_array($gallery))
            @foreach($gallery as $item)
                @php $na = explode('/', $item); $filename = array_pop($na); $t_name = implode('/', $na) . '/t_' . $filename @endphp
                <img
                        class="h-auto max-w-full rounded-lg cursor-pointer"
                        src="{{asset('storage' . $t_name)}}"
                        alt=""
                        @click="showModal = true, imgModalSrc = '{{asset('storage' . $item)}}'"
                >
            @endforeach
        @endif
    </div>
</div>
