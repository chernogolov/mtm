<x-app-layout>
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

                    <div class="mt-1 mb-4">
                        <a href="{{ route($res['route_prefix'] . '.create') }}">
                            <x-primary-button>
                                {{ __('Add') }}
                            </x-primary-button>
                        </a>
                    </div>
                    <form method="get" action="{{ route($res['route_prefix'] . '.index') }}" >
                        @csrf
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            #
                                        </th>
                                        @foreach($resource['catalog_fields'] as $f_name)
                                            <th scope="col" class="px-6 py-3">
                                                {{$fields->$f_name->title}}
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
                                                <input type="checkbox" class="h-6 w-6" name="delete[{{$item->id}}]">
                                            </td>
                                            @foreach($resource['catalog_fields'] as $f_name)
                                                <td class="px-6 py-3">
                                                    @if(isset($fields->$f_name->template))
                                                        <x-dynamic-component :component="'view-'.$fields->$f_name->template.'-field'" class="lg:col-span-2" :name="$f_name" :value="$item" :field="$fields->$f_name"/>
                                                    @else
                                                        <x-dynamic-component :component="'view-'.$fields->$f_name->type.'-field'" class="lg:col-span-2" :name="$f_name" :value="$item" :field="$fields->$f_name"/>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td class="px-6 py-4 flex justify-end">
                                                <a class="mr-4" href="{{ route($res['route_prefix'] . '.show', $item->id) }}" title="{{__('Show')}}">
                                                    <x-secondary-button >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        </svg>
                                                    </x-secondary-button>
                                                </a>
                                                <a href="{{ route($res['route_prefix'] . '.edit', $item->id) }}" title="{{__('Edit')}}">
                                                    <x-secondary-button >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                        </svg>
                                                    </x-secondary-button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="py-4">
                            <x-primary-button name="delete_selected" value="1">
                                удалить выбранные
                            </x-primary-button>
                        </div>
                        <div class="py-4">
                            {{ $items->links() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>