<x-mtm-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{__('View')}} {{ __($res['one_name']) }}
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
                            {{__('Created at')}}: {{$data->created_at}}
                        </div>
                        <div class="text-xs block">
                            {{__('Updated at')}}: {{$data->updated_at}}
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white ">
                    @foreach($res['view_fields'] as $key)
                        <div class="mb-6">
                            <div class="flex">
                                <label class="text-gray-700 w-1/3">
                                    {{$fields->$key->title}}
                                    @if(Auth::user()->id == 1)
                                        <br>
                                        <span class="text-xs text-gray-300">{{$fields->$key->type}}</span>
                                    @endif
                                </label>
                                <div class="w-2/3">
                                    @if(isset($fields->$key->template))
                                        <x-dynamic-component :component="'view-'.$fields->$key->template.'-field'" class="lg:col-span-2" :value="$data" :field="$fields->$key" :data="$fields->$key" :name="$key" :object="$data"/>
                                    @else
                                        @if(View::exists('mtm::components.view-'.$fields->$key->type.'-field'))
                                            <x-dynamic-component :component="'mtm::view-'.$fields->$key->type.'-field'" class="lg:col-span-2" :value="$data->$key" :field="$fields->$key" :data="$fields->$key" :name="$key" :object="$data"/>
                                        @else
                                            {{$data->$key}}
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                        <div class="mb-6">
                            <div class="flex">
                                <label class="text-gray-700 w-1/3">
                                    {{__('roles')}}
                                </label>
                                <div class="w-2/3">
                                     @foreach($data->getRoleNames() as $role)
                                        {{$role}}<br>
                                     @endforeach
                                </div>
                            </div>
                        </div>
                </div>
                <div class="v-100 flex justify-between bg-gray-50 p-6">
                    <a href="{{route($res['route_prefix'] . '.index')}}">
                        <x-secondary-button >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                            </svg>
                            {{__('Back')}}
                        </x-secondary-button>
                    </a>
                    <a class="mr-2" href="{{ route($res['route_prefix'] . '.edit', $data->id) }}" title="{{__('Edit')}}">
                        <x-secondary-button >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                            {{__('Edit')}}
                        </x-secondary-button>
                    </a>
                    @if(!empty($res->template))
                        @foreach($res->template as $k => $template)
                            <a href="{{ route($res['route_prefix'] . '.template', ['id' => $data->id, 'template' => $k]) }}" title='{{__('Get template')}} "{{$template->name}}"'>
                                <x-secondary-button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    {{__('Download template')}}
                                </x-secondary-button>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-mtm-layout>