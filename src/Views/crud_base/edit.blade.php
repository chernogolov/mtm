<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{__('Edit')}} {{ $res->one_name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="bg-gray-50 h-16 border-b border-gray-100 py-4 px-6 text-gray-400 flex justify-between">
                    <div class="text-xl">
                        ID {{$data->id}}
                    </div>
                    <div class="text-right">
                        <div class="text-xs block">
                            Создано: {{$data->created_at}}
                        </div>
                        <div class="text-xs block">
                            Обновлено: {{$data->updated_at}}
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                            <form method="POST" id="data-form" action="{{ route($res['route_prefix'] . '.update', [$res['route_prefix'] => $data->id]) }}" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html">
                                @method('PUT')
                                @csrf
                                <div class="mb-6">
                                    @foreach($res['editable_fields'] as $key)
                                        @php  $ext = json_decode($fields->$key->ext); @endphp
                                        <div class="mb-6">
                                            <div class="flex">
                                                <label class="text-gray-700 w-1/3">
                                                    {{$fields->$key->title}} @if(isset($ext->required)) * @endif
                                                    @if(Auth::user()->id == 1)
                                                        <br>
                                                        <span class="text-xs text-gray-300">{{$fields->$key->type}}</span>
                                                    @endif
                                                </label>
                                                <div class="w-2/3">
                                                @if(isset($f_data->template))
                                                    <x-dynamic-component :component="'edit-'.$fields->$key->template.'-field'" class="lg:col-span-2  w-1/3" :value="$data->$field" :name="$key" :data="$fields->$key" :object="$data" :res="$res"/>
                                                @else
                                                    @if(View::exists('components.edit-'.$fields->$key->type.'-field'))
                                                        <x-dynamic-component :component="'edit-'.$fields->$key->type.'-field'" class="lg:col-span-2" :value="$data->$key" :name="$key" :data="$fields->$key" :object="$data" :res="$res"/>
                                                    @else
                                                        <x-text-input id="$key" class="block mt-1 w-full" type="text" :name="$key" autocomplete="" :value="$data->$key" autofocus autocomplete="$key" :object="$data" :res="$res"/>
                                                    @endif
                                                @endif
                                                @error($key)
                                                <div class="text-sm text-red-600">{{ $message }}</div>
                                                @enderror
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex justify-between mt-6 pt-6">
                                    <a href="{{route($res['route_prefix'] . '.index')}}">
                                        <x-secondary-button class="mt-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                                            </svg>
                                            Назад
                                        </x-secondary-button>
                                    </a>

                                    <a class="mr-2" href="{{ route($res['route_prefix'] . '.show', $data->id) }}" title="{{__('Show')}}">
                                        <x-secondary-button class="mt-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            Просмотр
                                        </x-secondary-button>
                                    </a>

                                    <x-primary-button type="submit" form="data-form" class="mt-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                        Сохранить
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
{{--                <div class="bg-gray-200 flex mt-6 py-4 px-6 flex justify-center sm:rounded-lg">--}}
{{--                    <form id="delete" action="{{route($res['route_prefix'] . '.destroy', [strtolower($res['model_name'])  => $data->id ])}}" method="POST">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <x-submit-button form="delete" class="bg-gray-400 hover:bg-gray-500 text-white" onclick="return confirm('вы уверены?') ? true : false;">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />--}}
{{--                            </svg>--}}
{{--                            Удалить--}}
{{--                        </x-submit-button>--}}
{{--                    </form>--}}
{{--                </div>--}}
            </div>
            </div>
        </div>
</x-app-layout>