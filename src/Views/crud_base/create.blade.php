<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{__('Create')}} {{ __($res['one_name']) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route($res['route_prefix'] . '.store') }}" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html">
                        @csrf
                        @foreach($fields as $field => $data)
                            @php  $ext = json_decode($data->ext); @endphp
                            <div class="mb-6">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
                                    <label class="text-gray-700">
                                        {{$data->title}} @if(isset($ext->required)) * @endif
                                        @if(Auth::user()->id == 1)
                                            <br>
                                            <span class="text-xs text-gray-300">{{$data->type}}</span>
                                        @endif
                                    </label>
                                    @if(isset($data->template) && View::exists('components.add-'.$data->template.'-field'))
                                        <x-dynamic-component :component="'add-'.$data->template.'-field'" class="lg:col-span-2" :name="$field" :data="$data"/>
                                    @else
                                        @if(View::exists('components.add-'.$data->type.'-field'))
                                            <x-dynamic-component :component="'add-'.$data->type.'-field'" class="lg:col-span-2" :name="$field" :data="$data"/>
                                        @else
                                            <x-text-input id="$key" class="block mt-1 w-full" type="text" :name="$field" autocomplete="" autofocus autocomplete="$field"/>
                                        @endif

                                    @endif
                                </div>
                                @error($field)
                                    <div class="text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach

{{--                        <div class="mb-6">--}}
{{--                            <label class="block">--}}
{{--                                <span class="text-gray-700">Slug</span>--}}
{{--                                <input type="text" name="slug" class="block w-full mt-1 rounded-md" placeholder=""--}}
{{--                                       value="{{ old('slug') }}" />--}}
{{--                            </label>--}}
{{--                            @error('slug')--}}
{{--                            <div class="text-sm text-red-600">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="mb-6">--}}
{{--                            <label class="block">--}}
{{--                                <span class="text-gray-700">Content</span>--}}
{{--                                <textarea id="editor" class="block w-full mt-1 rounded-md" name="content" rows="3">{{ old('content') }}</textarea>--}}
{{--                            </label>--}}
{{--                            @error('content')--}}
{{--                            <div class="text-sm text-red-600">{{ $message }}</div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
                        <x-primary-button type="submit">
                            Сохранить
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>