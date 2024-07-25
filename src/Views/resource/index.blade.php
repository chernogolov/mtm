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

                    <div class="mt-1 mb-4">
                        <h1>
                            {{__('Resource edit')}}
                        </h1>
                    </div>
{{--                    <form method="get" action="{{ route($res['route_prefix'] . '.index') }}" >--}}
{{--                        @csrf--}}
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            {{__('Model')}}
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            {{__('Name')}}
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            {{__('Route prefix')}}
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            {{__('View prefix')}}
                                        </th>
                                        <th scope="col" class="px-6 py-3">

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($models as $model)
                                        @php $ma = explode('\\', $model) @endphp
                                        @php $mn = array_pop($ma) @endphp
                                        <tr>
                                            <td class="px-6 py-3">
                                                {{$model}}
                                            </td>
                                            <td class="px-6 py-3">
                                                @if(isset($items[$mn]))
                                                    {{$items[$mn]->name}}
                                                @endif
                                            </td>
                                            <td class="px-6 py-3">
                                                @if(isset($items[$mn]))
                                                    {{$items[$mn]->route_prefix}}
                                                @endif
                                            </td>
                                            <td class="px-6 py-3">
                                                @if(isset($items[$mn]))
                                                    {{$items[$mn]->view_prefix}}
                                                @endif
                                            </td>
                                            <td class="px-6 py-3 flex justify-end">
                                            @if(isset($items[$mn]))
                                                   <a href="{{ route('resources.edit', ['resource' => $items[$mn]->id]) }}">
                                                        <x-secondary-button class="mr-2">
                                                            {{ __('Edit') }}
                                                        </x-secondary-button>
                                                    </a>
                                                    <form id="des_{{$items[$mn]->id}}" action="{{ route('resources.destroy', $items[$mn]->id) }}" method="POST"
                                                          onsubmit="return confirm('{{ trans('are You Sure ? ') }}');"
                                                          style="display: inline-block;">
                                                        <input type="hidden" form="des_{{$items[$mn]->id}}" name="_method" value="DELETE">
                                                        <input type="hidden" form="des_{{$items[$mn]->id}}" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" form="des_{{$items[$mn]->id}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline cursor-pointer"
                                                               value="{{__('Delete')}}">
                                                    </form>
                                                @else
                                                    <a href="{{ route('resources.create', ['name' => $mn]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        {{ __('Add') }}
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
{{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
</x-mtm-layout>