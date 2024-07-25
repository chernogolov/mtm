@props(['data', 'value', 'field', 'name'])
@php $files = json_decode($value) @endphp
    @if(is_array($files))
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-6" x-data="" id="{{$name}}">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th class="px-6 py-3">
                Имя
            </th>
            <th class="px-6 py-3">
                Тип
            </th>
            <th class="px-6 py-3">
                Размер
            </th>
            <th class="px-6 py-3">
                Скачать
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($files as $k => $item)
            @php $na = explode('/', $item); $filename = array_pop($na); $ea = explode('.', $item); $ext = array_pop($ea); @endphp
            <tr id="{{$filename}}_row">
                <td class="px-6 py-4">
                    <a target="_blank" href="{{asset('storage/' . $item)}}" title="Скачать">
                        {{str_replace('.' . $ext, '', $filename)}}
                    </a>
                </td>
                <td class="px-6 py-4">
                    {{$ext}}
                </td>
                <td class="px-6 py-4">

                </td>
                <td class="flex justify-center gap-4 mt-1" >
                    <a target="_blank" href="{{asset('storage/' . $item)}}" title="Скачать">
                        <x-secondary-button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </x-secondary-button>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif