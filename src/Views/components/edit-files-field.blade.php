@props([
'disabled' => false,
'name',
'data',
'value'
])

<input multiple="multiple" type="file" {{ $disabled ? 'disabled' : '' }} name="new_{{$name}}[]" {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
@php $files = json_decode($value) @endphp
@if(is_array($files))
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-6" x-data="">
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
                    Опции
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
                    <td class="flex justify-end gap-4 mt-1" >
                        <a target="_blank" href="{{asset('storage/' . $item)}}" title="Скачать">
                            <x-secondary-button>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </x-secondary-button>
                        </a>
                            <input id="{{$filename}}_input" type="hidden" name="{{$name}}[]" value="{{$item}}">
                            <button type="button" @click="{{$name}}Remove('{{$filename}}')" id="{{$filename}}_btn"  class="inline-flex items-center px-4 bg-white border border-gray-300 rounded-md font-semibold text-xl text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                &times;
                            </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<script>
    function {{$name}}Remove(filename) {
        var t = document.getElementById(filename + '_row').getAttribute('title');
        if(t)
        {
            document.getElementById(filename + '_row').setAttribute('style', 'opacity:1;');
            document.getElementById(filename + '_row').removeAttribute('title');
            var name = document.getElementById(filename + '_input').getAttribute('name');
            document.getElementById(filename + '_input').setAttribute('name', name.replace('del_', ''));
            document.getElementById(filename + '_btn').innerHTML = "&times;";
        }
        else
        {
            document.getElementById(filename + '_row').setAttribute('style', 'opacity:0.3;');
            document.getElementById(filename + '_btn').setAttribute('style', 'background:#fff');
            document.getElementById(filename + '_row').setAttribute('title', 'Файл удалится при сохранении');
            var name = document.getElementById(filename + '_input').getAttribute('name');
            document.getElementById(filename + '_input').setAttribute('name', 'del_' + name);
            document.getElementById(filename + '_btn').innerHTML = "+";
        }

    }
</script>