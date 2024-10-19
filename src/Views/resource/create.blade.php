<x-mtm-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{__('Create')}} {{ __($res['one_name']) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div x-data="{ currentTab: 'data' }">
                        <div class="mb-4 ">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
                                <li @click="currentTab = 'data'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab" data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                        {{__('Base')}}
                                    </button>
                                </li>
                                <li @click="currentTab = 'fields'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                                        {{__('Fields')}}
                                    </button>
                                </li>
                                <li @click="currentTab = 'templates'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        {{__('Templates')}}
                                    </button>
                                </li>
                                <li @click="currentTab = 'access'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        {{__('Access')}}
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <form method="POST" id="data-form" action="{{ route($res['route_prefix'] . '.store') }}" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html">
                                @csrf
                                <div x-show="currentTab === 'data'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="mb-6">
                                        <div >
                                            <x-input-label for="ordering" :value="__('Order')" />
                                            <x-text-input id="ordering" name="data[ordering]" form="data-form" type="text" class="mt-1 block w-full" required autofocus autocomplete="ordering" />
                                            <x-input-error class="mt-2" :messages="$errors->get('ordering')" />
                                        </div>
                                        <div >
                                            <x-input-label for="name" :value="__('Name')" />
                                            <x-text-input id="name" name="data[name]" form="data-form" type="text" class="mt-1 block w-full" :value="Str::plural($name)" required autofocus autocomplete="name" />
                                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="one_name" :value="__('One name')" />
                                            <x-text-input id="one_name" name="data[one_name]" form="data-form" type="text" class="mt-1 block w-full" :value="$name" required autofocus autocomplete="one_name" />
                                            <x-input-error class="mt-2" :messages="$errors->get('one_name')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="route_prefix" :value="__('Route prefix')" />
                                            <x-text-input id="route_prefix" name="data[route_prefix]" form="data-form" type="text" class="mt-1 block w-full" :value="Str::lower($name)" required autofocus autocomplete="route_prefix" />
                                            <x-input-error class="mt-2" :messages="$errors->get('route_prefix')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="view_prefix" :value="__('View prefix')" />
                                            <x-text-input id="view_prefix" name="data[view_prefix]" form="data-form" type="text" class="mt-1 block w-full" :value="Str::lower($name)" required autofocus autocomplete="view_prefix" />
                                            <x-input-error class="mt-2" :messages="$errors->get('view_prefix')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="model_name" :value="__('Model name')" />
                                            <x-text-input id="model_name" name="data[model_name]" form="data-form" type="text" class="mt-1 block w-full" :value="$name" required autofocus autocomplete="model_name" />
                                            <x-input-error class="mt-2" :messages="$errors->get('model_name')" />
                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'fields'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="relative overflow-x-auto">
                                        @php $ff = $fields; $ff = array_diff($fields, array('id', 'created_at', 'updated_at')); @endphp
                                        <div class="mt-4">
                                            <x-input-label for="model_name" :value="__('Editable fields')" />
                                            <x-text-input id="model_name" name="data[editable_fields]" form="data-form" type="text" class="mt-1 block w-full" :value="implode(',', $ff)" required autofocus autocomplete="model_name" />
                                            <x-input-error class="mt-2" :messages="$errors->get('model_name')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="model_name" :value="__('Catalog fields')" />
                                            <x-text-input id="model_name" name="data[catalog_fields]" form="data-form" type="text" class="mt-1 block w-full" :value="implode(',', $ff)" required autofocus autocomplete="model_name" />
                                            <x-input-error class="mt-2" :messages="$errors->get('model_name')" />
                                        </div>
                                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    {{__('Field')}}
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    {{__('Name')}}
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    {{__('Type')}}
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    {{__('Template')}}
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    {{__('Options')}}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ff as $field)
                                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            {{$field}}
                                                        </th>
                                                        <td class="px-6 py-4">
                                                            <x-text-input id="{{$field}}_title" name="fields[{{$field}}][title]" form="data-form" type="text" class="mt-1 block w-full" :value="__($field)" required autofocus autocomplete="{{$field}}_title" />
                                                            <x-input-error class="mt-2" :messages="$errors->get($field.'title')" />
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <select id="{{$field}}_type" name="fields[{{$field}}][type]" form="data-form" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="{{$field}}_type" />
                                                                <option value="string">{{__('String')}}</option>
                                                                <option value="link">{{__('Link')}}</option>
                                                                <option value="textarea">{{__('Text')}}</option>
                                                                <option value="text_editor">{{__('Editor')}}</option>
                                                                <option value="date">{{__('Date')}}</option>
                                                                <option value="datetime">{{__('Datetime')}}</option>
                                                                <option value="deadline">{{__('Deadline')}}</option>
                                                                <option value="list">{{__('List')}}</option>
                                                                <option value="file">{{__('File')}}</option>
                                                                <option value="files">{{__('Files')}}</option>
                                                                <option value="image">{{__('Image')}}</option>
                                                                <option value="gallery">{{__('Gallery')}}</option>
                                                                <option value="orm">{{__('Orm')}}</option>
                                                                <option value="address">{{__('Address')}}</option>
                                                                <option value="coords">{{__('Coords')}}</option>
                                                                <option value="passwd">{{__('Password')}}</option>
                                                            </select>
                                                            <x-input-error class="mt-2" :messages="$errors->get($field.'title')" />
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <x-text-input id="{{$field}}_template" name="fields[{{$field}}][template]" form="data-form" type="text" class="mt-1 block w-full" />
                                                            <x-input-error class="mt-2" :messages="$errors->get($field.'template')" />
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <textarea id="{{$field}}_ext"  name="fields[{{$field}}][ext]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                                            <x-input-error class="mt-2" :messages="$errors->get($field.'ext')" />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                                <div x-show="currentTab === 'templates'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    {{__('Templates')}}
                                </div>
                                <div x-show="currentTab === 'access'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    {{__('Access')}}
                                </div>
                                <div class="flex justify-between">
                                    <a href="{{route('resources.index')}}">
                                        <x-secondary-button class="mt-4">
                                            {{__('Back')}}
                                        </x-secondary-button>
                                    </a>
                                    <x-primary-button type="submit" form="data-form" class="mt-4">
                                        {{__('Save')}}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-mtm-layout>
