<x-mtm-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __($res['name']) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session()->has('status'))
                        <div class="flex justify-center items-center">

                            <p class="ml-3 text-sm font-bold text-green-600">{{ session()->get('status') }}</p>
                        </div>
                    @endif

                    <div class="mt-1 mb-4 flex justify-between">
                        @if($mtmUser->hasPermissionTo('create '.Str::lower($res['model_name'])) || $mtmUser->hasRole('Super-Admin'))
                            <a href="{{ route($res['route_prefix'] . '.create') }}">
                                <x-primary-button>
                                    {{ __('Add') }}
                                </x-primary-button>
                            </a>
                        @endif
                        <select title="Количество записей на странице" class="inline-flex items-center pl-4 pr-8 py-2 border  rounded-md font-semibold text-sm  tracking-widest  transition ease-in-out duration-150" id="onPage" onchange="if (this.value) window.location.href= '{{route($res['route_prefix'] . '.index')}}?on_pages=' + this.value">
                            <option value="10" @if($on_pages == 10) selected @endif>10</option>
                            <option value="20" @if($on_pages == 20) selected @endif>20</option>
                            <option value="50" @if($on_pages == 50) selected @endif>50</option>
                            <option value="100" @if($on_pages == 100) selected @endif>100</option>
                        </select>
                    </div>
                    <form method="get" action="{{ route($res['route_prefix'] . '.index') }}" >
                        @csrf
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" x-data="AlpineSelect()">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        <input type="checkbox" @click="selectall=!selectall" class="h-6 w-6">
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        №
                                    </th>
                                    @foreach($resource['catalog_fields'] as $f_name)
                                        <th scope="col" class="px-6 py-3">
                                            <div class="flex">
                                                {{$fields->$f_name->title}}
                                                @if(in_array($fields->$f_name->type, ['string', 'date', 'datetime', 'deadline', 'list', 'address', 'coords', 'integer']))
                                                    @if(isset($order_by) && $order_by == $f_name)
                                                        <div class="text-black">

                                                            @else
                                                                <div class="text-gray-300">
                                                                    @endif
                                                                    @if(isset($order_by_direction) && $order_by_direction == 'DESC')
                                                                        <a href="{{route($res['route_prefix'] . '.index', ['order_by' => $f_name, 'order_by_direction' => 'ASC'])}}">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                                                            </svg>
                                                                        </a>
                                                                    @else
                                                                        <a href="{{route($res['route_prefix'] . '.index', ['order_by' => $f_name, 'order_by_direction' => 'DESC'])}}">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                                                            </svg>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                        </th>
                                    @endforeach
                                    <th scope="col" class="px-6 py-3">

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <input type="checkbox" class="h-6 w-6" x-bind:checked="selectall" name="delete[{{$item->id}}]">
                                        </td>
                                        <td class="px-6 py-4">
                                            {{$item->id}}
                                        </td>
                                        @foreach($resource['catalog_fields'] as $f_name)
                                            <td class="px-6 py-3">
                                                <div class="flex">
                                                    @if(isset($fields->$f_name->template))
                                                        <x-dynamic-component :component="'view-'.$fields->$f_name->template.'-field'" class="lg:col-span-2" :field="$f_name" :value="$item" :field="$fields->$f_name"/>
                                                    @else
                                                        @if($fields->$f_name->type == 'gallery')
                                                            @php $gallery = json_decode($item->$f_name) @endphp
                                                            @if(is_array($gallery) && isset($gallery[0]))
                                                                @php $na = explode('/', $gallery[0]); $filename = array_pop($na); $t_name = implode('/', $na) . '/t_' . $filename @endphp
                                                                <a class="text-sm ml-1 py-2" href="{{ route($res['route_prefix'] . '.show', $item->id) }}#{{$f_name}}">
                                                                    <img
                                                                            class="h-16 max-w-full rounded-lg cursor-pointer"
                                                                            src="{{asset('storage' . $t_name)}}"
                                                                            alt=""
                                                                    >
                                                                </a>
                                                                </div>
                                                                @if(count($gallery) > 1)
                                                                    <a class="text-sm ml-1 py-2" href="{{ route($res['route_prefix'] . '.show', $item->id) }}#{{$f_name}}">
                                                                        <span >+{{count($gallery)-1}}</span>
                                                                    </a>
                                                                @endif
                                                             @endif
                                                        @elseif($fields->$f_name->type == 'files')
                                                            @php $files = json_decode($item->$f_name) @endphp
                                                            @if(is_array($files) && isset($files[0]))
                                                                @if(count($files) > 1)
                                                                    <a class="text-sm ml-1 py-2" href="{{ route($res['route_prefix'] . '.show', $item->id) }}#{{$f_name}}">
                                                                        <span>{{count($files)}} шт.</span>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @elseif($fields->$f_name->type == 'list')
                                                            @php $ext = json_decode($fields->$f_name->ext); $list = []; $v = $item->$f_name @endphp
                                                            @if(isset($ext->list))
                                                                {{$ext->list->$v}}
                                                            @endif
                                                        @elseif($fields->$f_name->type == 'text_editor')
                                                            {{Str::words(strip_tags($item->$f_name), 10)}}
                                                        @elseif($fields->$f_name->type == 'orm')
                                                            @if(isset($item->$f_name->id))
                                                                @php $ext = json_decode($fields->$f_name->ext); @endphp
                                                                @if(isset($ext->fields))
                                                                    @foreach($ext->fields as $key => $value)
                                                                        {{$item->$f_name->$key}}&nbsp;
                                                                    @endforeach
                                                                @else
                                                                    {{__('add filed to ext')}}
                                                                @endif
                                                            @else
                                                                @if(is_array($item->$f_name))
                                                                    @foreach($item->$f_name as $v)
                                                                        <a class="text-sm ml-1 py-2" href="{{ route($res['route_prefix'] . '.show', $item->id) }}#{{$f_name}}">
                                                                            #{{$v->id}}@if(!$loop->last), @endif
                                                                        </a>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @elseif($fields->$f_name->type == 'integer')
                                                            <span class="whitespace-nowrap">{{number_format($item->$f_name, 0, ',', ' ')}}</span>
                                                        @else
                                                            {{$item->$f_name}}
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        @endforeach
                                <td class="px-6 py-4 flex justify-end">
                                    <a class="mr-2" href="{{ route($res['route_prefix'] . '.show', $item->id) }}" title="{{__('Show')}}">
                                        <button type="button" class = "inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </button>
                                    </a>
                            @if($mtmUser->hasPermissionTo('edit '.Str::lower($res['model_name'])) || $mtmUser->hasRole('Super-Admin'))
                                <a class="mr-2" href="{{ route($res['route_prefix'] . '.edit', $item->id) }}" title="{{__('Edit')}}">
                                    <button  type="button" class = "inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                </a>
                            @endif
                            @if(!empty($res->template) && Route::has($res['route_prefix'] . '.template'))
                                @foreach($res->template as $k => $template)
                                    <a class="mr-2" target="_blank" href="{{ route($res['route_prefix'] . '.template', ['id' => $item->id, 'template' => $k]) }}" title='{{__('Get template')}} "{{$template->name}}"'>
                                        <button type="button" class = "inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        </button>
                                    </a>
                                @endforeach
                            @endif
                            @if($mtmUser->hasPermissionTo('edit '.Str::lower($res['model_name'])) || $mtmUser->hasRole('Super-Admin'))
                                @if(Route::has($res['route_prefix'] . '.clone'))
                                    <a href="{{ route($res['route_prefix'] . '.clone', $item->id) }}" title="{{__('Clone')}}. Файлы не дублируются, при удалении в исходнике удалятся из клона!">
                                        <button  type="button" class = "inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                            </svg>
                                        </button>
                                    </a>
                                @endif
                            @endif
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                </div>
                <div class="py-4 flex justify-between" x-data="">
                    @if($mtmUser->hasPermissionTo('delete '.Str::lower($res['model_name'])) || $mtmUser->hasRole('Super-Admin'))
                        <x-primary-button name="delete_selected" value="1">
                            {{__('Delete selected')}}
                        </x-primary-button>
                    @endif
                    @if(Route::has($res['route_prefix'] . '.export') && isset($res->export_fields) && count($res->export_fields) > 1)
                        <a href="{{ route($res['route_prefix'] . '.export') }}" target="_blank" id="submitF" x-on:click="submitDisable('submitF')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('to Excel') }}
                        </a>
                    @endif
                </div>
                <div class="py-4">
                    {{ $items->withQueryString()->links() }}
                </div>
                </form>
                @if($mtmUser->hasPermissionTo('edit '.Str::lower($res['model_name'])) || $mtmUser->hasRole('Super-Admin'))
                    @if(Route::has($res['route_prefix'] . '.import') && isset($res->export_fields) && count($res->export_fields) > 1)
                        <br>
                        <hr>
                        <br>
                        <div class="py-4  justify-between w-100" x-data="">
                            <form method="POST" id="import_form" class="form-inline flex justify-between pb-6" action="{{ route($res['route_prefix'] . '.import') }}" enctype="multipart/form-data">
                                @csrf
                                @method('get')
                                <input type="file" name="file" class="block w-full mt-1 rounded-md mx-4"  form="import_form" required="required"/>
                                <x-primary-button type="submit" form="import_form">
                                    Загрузить&nbsp;XLS
                                </x-primary-button>
                            </form>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    </div>
</x-mtm-layout>
<script>

    function AlpineSelect(){
        return {
            selectall: false,
        };
    }

    function setCookie(e) {
        console.log(e.target.getAttribute('val'))
    }

    function submitDisable(id){
        var hrf = document.getElementById(id).getAttribute('href');
        setTimeout(
            function()
            {
                document.getElementById(id).classList.add("opacity-60");
                document.getElementById(id).removeAttribute('href');
                document.getElementById(id).innerHTML = '<div class="flex items-center justify-center"><div class="w-4 h-4 border-b-2 border-white rounded-full animate-spin mr-2"></div></div> Excel';
            },
            100);
        setTimeout(
            function()
            {
                document.getElementById(id).classList.remove("opacity-60");
                document.getElementById(id).setAttribute('href', hrf);
                document.getElementById(id).innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>Excel';
            },
            5000,
            hrf);
    }
</script>
