@props(['data', 'value', 'name', 'object'])
@php $ext = json_decode($data->ext) @endphp
@php $resource = (object)\App\Models\Resource::where('model_name', ucfirst($name))->first(); @endphp

<div class="flex gap-6">
    <a target="_blank" href="{{asset($name . '/create?' . strtolower($res->model_name) . '=' . $object->id)}}">
        <x-secondary-button class="h-12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
            Создать {{$data->title}}
        </x-secondary-button>
    </a>
</div>

@if($value->count() > 0)
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="{{$name}}">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                ID
            </th>
            @if(isset($ext->fields))
                @foreach($ext->fields as $key => $itm)
                    <th scope="col" class="px-6 py-3">
                        {{$resource->fields->$key->title}}
                    </th>
                @endforeach
            @endif
            <th>
                операции
            </th>
        </tr>
        </thead>
        <tbody>
        @if(isset($value->id))
            @php $value = [$value]; @endphp
        @endif

        @foreach($value as $k => $item)
            <tr id="row_{{$name}}_{{$item->id}}">
                <td class="px-6 py-4" >
                    {{$item->id}}
                </td>
                @if(isset($ext->fields))
                    @foreach($ext->fields as $key => $im)
                        @php $field = $resource->fields->$key @endphp
                        <td class="px-6 py-4">
                            @if($field->type == 'list')
                                @php $f_ext = json_decode($field->ext) @endphp
                                @if($f_ext->list)
                                    @php $f_key = $item->$key @endphp
                                    {{$f_ext->list->$f_key}}
                                @endif
                            @else
                                {{$item->$key}}
                            @endif
                        </td>
                    @endforeach
                @endif
                <td class="flex justify-end gap-4 mt-1" x-data="">
                    <a target="_blank" href="{{route($resource->route_prefix . '.show', [$name => $item->id])}}" title="Перейти к объекту">
                        <x-secondary-button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </x-secondary-button>
                    </a>
                    <a target="_blank" href="{{route($resource->route_prefix . '.edit', [$name => $item->id])}}" title="Редактировать объект">
                        <x-secondary-button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                        </x-secondary-button>
                    </a>
                    {{--                <input id="inp_{{$name}}_{{$item->id}}" type="hidden" name="d_{{$name}}[]" value="{{$item->id}}">--}}
                    {{--                <button type="button" @click="removeOrm({{$item->id}})" id="btn_{{$name}}_{{$item->id}}"  class="inline-flex items-center px-4 bg-white border border-gray-300 rounded-md font-semibold text-xl text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">--}}
                    {{--                    &times;--}}
                    {{--                </button>--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif