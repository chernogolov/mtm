@props([
'disabled' => false,
'name',
'data',
'value'
])

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-data="">
    @php $gallery = json_decode($value) @endphp
    @if(is_array($gallery))
        @foreach($gallery as $k => $item)
            @php $na = explode('/', $item); $filename = array_pop($na); $t_name = implode('/', $na) . '/t_' . $filename @endphp
            <div class="relative" id="{{$filename}}" >
                <button id="{{$filename}}_btn" type="button" class="-right-1 -top-1 xl:right-6 absolute px-2 z-50 border border-gray-200 cursor-pointer rounded-lg bg-white text-2xl" @click="remove_{{$name}}('{{$filename}}')">
                    &times;
                </button>
                <div class="absolute bottom-1 left-2 text-xs" id="{{$filename}}_msg">

                </div>
                <img id="{{$filename}}_img" class="h-auto max-w-full rounded-lg" src="{{asset('storage' . $t_name)}}" alt="">
                <input id="{{$filename}}_input" type="hidden" name="{{$name}}[{{$k}}]" value="{{$item}}">
            </div>
        @endforeach
    @endif
</div>

<br>
<input multiple="multiple" type="file" {{ $disabled ? 'disabled' : '' }} name="new_{{$name}}[]" {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}
>

<script>
    function remove_{{$name}}(filename) {
        var t = document.getElementById(filename).getAttribute('title');
        if(t)
        {
            document.getElementById(filename + '_img').setAttribute('style', 'opacity:1;');
            document.getElementById(filename).removeAttribute('title');
            var name = document.getElementById(filename + '_input').getAttribute('name');
            document.getElementById(filename + '_input').setAttribute('name', name.replace('del_', ''));
            document.getElementById(filename + '_btn').innerHTML = "&times;";
            document.getElementById(filename + '_msg').innerHTML = "";
        }
        else
        {
            document.getElementById(filename + '_img').setAttribute('style', 'opacity:0.3;');
            document.getElementById(filename + '_btn').setAttribute('style', 'background:#fff');
            document.getElementById(filename).setAttribute('title', 'Изображение удалится при сохранении');
            var name = document.getElementById(filename + '_input').getAttribute('name');
            document.getElementById(filename + '_input').setAttribute('name', 'del_' + name);
            document.getElementById(filename + '_btn').innerHTML = "+";
            document.getElementById(filename + '_msg').innerHTML = "Помечено на удаление.";
        }

    }
</script>