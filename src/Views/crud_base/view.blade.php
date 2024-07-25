<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Просмотр {{ __($res['one_name']) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 lg:gap-8">
                        @foreach($data as $key => $item)
                            <div class="mb-6">
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
                                    <label class="text-gray-700">
                                        {{$key}}
                                    </label>
                                    {{$data->type}}
                                    {{$field}}
                                    @if(isset($data->template))

                                        <x-dynamic-component :component="'view-'.$data->template.'-field'" class="lg:col-span-2" :name="$field" :data="$data"/>
                                    @else

                                        @if(View::exists('components.view-'.$data->type.'-field'))
                                            <x-dynamic-component :component="'view-'.$data->type.'-field'" class="lg:col-span-2" :name="$field" :data="$data"/>
                                        @else
                                            {{$item}}
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>