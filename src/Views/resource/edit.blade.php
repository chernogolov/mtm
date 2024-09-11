<x-mtm-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{__('Edit')}} {{ $resource->one_name }}
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
                                        {{__('Basic')}}
                                    </button>
                                </li>
                                <li @click="currentTab = 'fields'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                                        {{__('Fields')}}
                                    </button>
                                </li>
                                <li @click="currentTab = 'relations'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                                        {{__('Relations')}}
                                    </button>
                                </li>
                                <li @click="currentTab = 'templates'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        {{__('Templates')}}
                                    </button>
                                </li>
                                <li @click="currentTab = 'widgets'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        {{__('Widgets')}}
                                    </button>
                                </li>
                                <li @click="currentTab = 'forms'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        {{__('Forms')}}
                                    </button>
                                </li>
                                <li @click="currentTab = 'api'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        {{__('API')}}
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
                            <form method="POST" id="data-form" action="{{ route('resources.update', ['resource' => $resource->id]) }}" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html">
                                @method('PUT')
                                @csrf
                                <div x-show="currentTab === 'data'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="mb-6">
                                        <div >
                                            <x-input-label for="name" :value="__('Name')" />
                                            <x-text-input id="name" name="data[name]" form="data-form" type="text" class="mt-1 block w-full" :value="$resource->name" required autofocus autocomplete="name" />
                                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="one_name" :value="__('One name')" />
                                            <x-text-input id="one_name" name="data[one_name]" form="data-form" type="text" class="mt-1 block w-full" :value="$resource->one_name" required autofocus autocomplete="one_name" />
                                            <x-input-error class="mt-2" :messages="$errors->get('one_name')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="route_prefix" :value="__('Route prefix')" />
                                            <x-text-input id="route_prefix" name="data[route_prefix]" form="data-form" type="text" class="mt-1 block w-full" :value="$resource->route_prefix" required autofocus autocomplete="route_prefix" />
                                            <x-input-error class="mt-2" :messages="$errors->get('route_prefix')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="view_prefix" :value="__('View prefix')" />
                                            <x-text-input id="view_prefix" name="data[view_prefix]" form="data-form" type="text" class="mt-1 block w-full" :value="$resource->view_prefix" required autofocus autocomplete="view_prefix" />
                                            <x-input-error class="mt-2" :messages="$errors->get('view_prefix')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="model_name" :value="__('Model name')" />
                                            <x-text-input id="model_name" name="data[model_name]" form="data-form" type="text" class="mt-1 block w-full" :value="$resource->model_name" required autofocus autocomplete="model_name" />
                                            <x-input-error class="mt-2" :messages="$errors->get('model_name')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="model_name" :value="__('Truncate')" />
                                            <a href="{{route('resources.clear', ['id' => $resource->id])}}" onclick="return confirm('{{ __('Are You Sure') }}?');">
                                                <x-secondary-button class="mt-1 block">
                                                    {{__('Delete all data from table')}}
                                                </x-secondary-button>
                                            </a>
                                            <x-input-error class="mt-2" :messages="$errors->get('model_name')" />
                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'fields'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="relative overflow-x-auto">
                                        <div class="mt-4">
                                            <x-input-label for="all_fields" :value="__('all fields')"/>
                                            <x-text-input id="all_fields" type="text" class="mt-1 block w-full" :value="implode(',', array_keys((array)$resource->fields))"/>
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="catalog_fields" :value="__('catalog fields')" />
                                            <x-text-input id="catalog_fields" name="data[catalog_fields]" form="data-form" type="text" class="mt-1 block w-full" :value="$resource->catalog_fields" required autofocus autocomplete="catalog_fields" />
                                            <x-input-error class="mt-2" :messages="$errors->get('data.catalog_fields')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="view_fields" :value="__('view fields')" />
                                            <x-text-input id="view_fields" name="data[view_fields]" form="data-form" type="text" class="mt-1 block w-full" :value="$resource->view_fields" required autofocus autocomplete="view_fields" />
                                            <x-input-error class="mt-2" :messages="$errors->get('data.view_fields')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="editable_fields" :value="__('editable fields')" />
                                            <x-text-input id="editable_fields" name="data[editable_fields]" form="data-form" type="text" class="mt-1 block w-full" :value="$resource->editable_fields" required autofocus autocomplete="editable_fields" />
                                            <x-input-error class="mt-2" :messages="$errors->get('data.editable_fields')" />
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="export_fields" :value="__('export fields')" />
                                            <x-text-input id="export_fields" name="data[export_fields]" form="data-form" type="text" class="mt-1 block w-full" :value="$resource->export_fields" autofocus autocomplete="export_fields" />
                                            <x-input-error class="mt-2" :messages="$errors->get('data.export_fields')" />
                                        </div>


                                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 w-1/12">
                                                    {{__('Field')}}
                                                </th>
                                                <th scope="col" class="px-6 py-3 w-2/12">
                                                    {{__('Name')}}
                                                </th>
                                                <th scope="col" class="px-6 py-3 w-3/12">
                                                    {{__('Type')}}
                                                </th>
                                                <th scope="col" class="px-6 py-3 w-2/12">
                                                    {{__('Template')}}
                                                </th>
                                                <th scope="col" class="px-6 py-3 w-4/12">
                                                    {{__('Options')}}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($resource->fields as $key => $field)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{$key}}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        <x-text-input id="{{$key}}_title" name="fields[{{$key}}][title]" form="data-form" type="text" class="mt-1 block w-full" :value="$field->title" required autofocus autocomplete="{{$key}}_title" />
                                                        <x-input-error class="mt-2" :messages="$errors->get($key.'title')" />
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <select id="{{$key}}_type" name="fields[{{$key}}][type]" form="data-form" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="{{$key}}_type" />
                                                        <option value="string" @if($field->type == 'string') selected @endif>{{__('String')}}</option>
                                                        <option value="link" @if($field->type == 'link') selected @endif>{{__('Link')}}</option>
                                                        <option value="textarea" @if($field->type == 'textarea') selected @endif>{{__('Text')}}</option>
                                                        <option value="text_editor" @if($field->type == 'text_editor') selected @endif>{{__('Editor')}}</option>
                                                        <option value="date" @if($field->type == 'date') selected @endif>{{__('Date')}}</option>
                                                        <option value="datetime" @if($field->type == 'datetime') selected @endif>{{__('Datetime')}}</option>
                                                        <option value="deadline" @if($field->type == 'deadline') selected @endif>{{__('Deadline')}}</option>
                                                        <option value="list" @if($field->type == 'list') selected @endif>{{__('List')}}</option>
                                                        <option value="file" @if($field->type == 'file') selected @endif>{{__('File')}}</option>
                                                        <option value="files" @if($field->type == 'files') selected @endif>{{__('Files')}}</option>
                                                        <option value="image" @if($field->type == 'image') selected @endif>{{__('Image')}}</option>
                                                        <option value="gallery" @if($field->type == 'gallery') selected @endif>{{__('Gallery')}}</option>
                                                        <option value="orm" @if($field->type == 'orm') selected @endif>{{__('Orm')}}</option>
                                                        <option value="address" @if($field->type == 'address') selected @endif>{{__('Address')}}</option>
                                                        <option value="coords" @if($field->type == 'coords') selected @endif>{{__('Coordinates')}}</option>
                                                        <option value="passwd" @if($field->type == 'passwd') selected @endif>{{__('Password')}}</option>
                                                        </select>
                                                        <x-input-error class="mt-2" :messages="$errors->get($key.'title')" />
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <x-text-input id="{{$key}}_template" name="fields[{{$key}}][template]" form="data-form" type="text" class="mt-1 block w-full" :value="$field->template" />
                                                        <x-input-error class="mt-2" :messages="$errors->get($key.'template')" />
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div id="editor_{{$key}}" class="w-100 h-40 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></div>
                                                        <textarea id="{{$key}}_ext"  name="fields[{{$key}}][ext]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">@if(isset($field->ext)){{$field->ext}}@endif</textarea>
                                                        <x-input-error class="mt-2" :messages="$errors->get($key.'ext')" />
                                                        <script src="/vendor/mtm/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
                                                        <script>
                                                            var editor_{{$key}} = ace.edit("editor_{{$key}}");
                                                            document.getElementById('{{$key}}_ext').setAttribute('style', 'visibility:hidden;');
                                                            var val = document.getElementById('{{$key}}_ext').value;
                                                            editor_{{$key}}.getSession().setValue(val);
                                                            editor_{{$key}}.getSession().on('change', function() {
                                                                document.getElementById('{{$key}}_ext').value = editor_{{$key}}.getSession().getValue();
                                                            });

                                                            editor_{{$key}}.setTheme("ace/theme/github");
                                                            editor_{{$key}}.session.setMode("ace/mode/json");
                                                        </script>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @php $ff = $fields; $ff = array_diff($fields, array_keys((array)$resource->fields)); @endphp

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
                                                        <div id="editor_{{$field}}" class="w-100 h-40 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></div>
                                                        <textarea id="{{$field}}_ext"  name="fields[{{$field}}][ext]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                                        <x-input-error class="mt-2" :messages="$errors->get($field.'ext')" />
                                                        <script src="/vendor/mtm/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
                                                        <script>
                                                            var editor_{{$field}} = ace.edit("editor_{{$field}}");
                                                            document.getElementById('{{$field}}_ext').setAttribute('style', 'visibility:hidden;');
                                                            var val = document.getElementById('{{$field}}_ext').value;
                                                            editor_{{$field}}.getSession().setValue(val);
                                                            editor_{{$field}}.getSession().on('change', function() {
                                                                document.getElementById('{{$field}}_ext').value = editor_{{$field}}.getSession().getValue();
                                                            });

                                                            editor_{{$field}}.setTheme("ace/theme/github");
                                                            editor_{{$field}}.session.setMode("ace/mode/json");
                                                        </script>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'relations'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="relations-tab">
                                    {{__('Relations')}}
                                    <div class="mb-6">
                                        <div>
                                            <table>
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 w-2/12">
                                                        {{__('Slug')}}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 w-2/12">
                                                        {{__('Name')}}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 w-3/12">
                                                        {{__('Type')}}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 w-2/12">
                                                        {{__('Template')}}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 w-3/12">
                                                        {{__('Options')}}
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            <x-text-input id="orm_name" name="orm[name]" form="data-form" type="text" class="mt-1 block w-full" autofocus autocomplete="orm_name" />
                                                            <x-input-error class="mt-2" :messages="$errors->get('orm.name')" />
                                                        </th>
                                                        <td class="px-6 py-4">
                                                            <x-text-input id="orm_title" name="orm[title]" form="data-form" type="text" class="mt-1 block w-full" autofocus autocomplete="orm_title" />
                                                            <x-input-error class="mt-2" :messages="$errors->get('orm.title')" />
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <select id="orm_type" name="orm[type]" form="data-form" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="orm_type" />
                                                            <option value="hasOne">{{__('One to one')}}</option>
                                                            <option value="belongsTo">{{__('One to one (return)')}}</option>
                                                            <option value="hasMany">{{__('One to more')}}</option>
                                                            <option value="belongsTo">{{__('One to more (return)')}}</option>
                                                            <option value="belongsToMany">{{__('More to more')}}</option>
                                                            </select>
                                                            <x-input-error class="mt-2" :messages="$errors->get('orm.type')" />
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <x-text-input id="orm_template" name="orm[template]" form="data-form" type="text" class="mt-1 block w-full" />
                                                            <x-input-error class="mt-2" :messages="$errors->get('orm.template')" />
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            {{__('Create relations for set up')}}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'templates'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    {{__('Upload template')}}
                                    <div class="mb-6">
                                        <div >
                                            @if($resource->template)
                                                @foreach($resource->template as $k => $template)
                                                    <div class="w-100 mb-4 mt-4">
                                                        {{$k+1}}.&nbsp;{{$template->name}}
                                                        <a class="ml-4 underline" href="{{asset('storage/' . $template->file)}}">скачать</a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <x-text-input type="file" id="template" name="template" form="data-form" class="mt-1 block w-full" autofocus autocomplete="template" />
                                            <x-input-error class="mt-2" :messages="$errors->get('template')" />
                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'widgets'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    {{__('Widgets')}}
                                </div>
                                <div x-show="currentTab === 'forms'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    {{__('Forms')}}
                                    <div class="mb-6">
                                        <div >
                                            <x-input-label for="form_fields" :value="__('Form fields')" />
                                            <x-text-input type="text" id="form_fields" name="data[form_fields]" form="data-form" class="mt-1 block w-full" :value="$resource->form_fields" autofocus autocomplete="form_fields" />
                                            <x-input-error class="mt-2" :messages="$errors->get('form_fields')" />
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <div >
                                            {{__('Form link')}}: <a href="{{Asset('form/' . strtolower($resource->model_name))}}">{{Asset('form/' . strtolower($resource->model_name))}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'api'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    {{__('API')}}
                                    <div class="mb-6">
                                        <div >
                                            <x-input-label for="api_fields" :value="__('API fields')" />
                                            <x-text-input type="text" id="api_fields" name="data[api_fields]" form="data-form" class="mt-1 block w-full" :value="$resource->api_fields" autofocus autocomplete="api_fields" />
                                            <x-input-error class="mt-2" :messages="$errors->get('api_fields')" />
                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'access'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="pb-6">
                                        {{__('Access')}}
                                    </div>
                                    @foreach(\Spatie\Permission\Models\Permission::where('name', 'like', '%'.Str::lower($resource->model_name).'%')->get() as $permission)
                                        <div class="mb-6">
                                            <div class="flex">
                                                <label class="text-gray-700 w-1/3">
                                                    {{$permission['name']}}
                                                </label>
                                                <div class="w-2/3">
                                                    <select multiple="multiple" name="permissions[{{$permission['name']}}][]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                                                        <option value="">{{__(' No roles')}}</option>
                                                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                                            <option value="{{$role['name']}}" @if($permission->hasRole($role['name'])) selected @endif>{{$role['name']}}</option>
                                                        @endforeach
                                                    </select>
{{--                                                    @error($key)--}}
{{--                                                    <div class="text-sm text-red-600">{{ $message }}</div>--}}
{{--                                                    @enderror--}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
