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
                                        Основное
                                    </button>
                                </li>
                                <li @click="currentTab = 'fields'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                                        Поля
                                    </button>
                                </li>
                                <li @click="currentTab = 'relations'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dashboard-styled-tab" data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                                        Отношения
                                    </button>
                                </li>
                                <li @click="currentTab = 'templates'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        Шаблоны
                                    </button>
                                </li>
                                <li @click="currentTab = 'widgets'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        Виджеты
                                    </button>
                                </li>
                                <li @click="currentTab = 'forms'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        Формы
                                    </button>
                                </li>
                                <li @click="currentTab = 'api'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        API
                                    </button>
                                </li>
                                <li @click="currentTab = 'access'" class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="contacts-styled-tab" data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">
                                        Доступ
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
                                                    Поле
                                                </th>
                                                <th scope="col" class="px-6 py-3 w-2/12">
                                                    Имя(рус)
                                                </th>
                                                <th scope="col" class="px-6 py-3 w-3/12">
                                                    Тип
                                                </th>
                                                <th scope="col" class="px-6 py-3 w-2/12">
                                                    Шаблон
                                                </th>
                                                <th scope="col" class="px-6 py-3 w-4/12">
                                                    Дополнительно
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
                                                        <option value="string" @if($field->type == 'string') selected @endif>Строка</option>
                                                        <option value="link" @if($field->type == 'link') selected @endif>Ссылка</option>
                                                        <option value="textarea" @if($field->type == 'textarea') selected @endif>Текст</option>
                                                        <option value="text_editor" @if($field->type == 'text_editor') selected @endif>Редактор</option>
                                                        <option value="date" @if($field->type == 'date') selected @endif>Дата</option>
                                                        <option value="datetime" @if($field->type == 'datetime') selected @endif>Дата и время</option>
                                                        <option value="deadline" @if($field->type == 'deadline') selected @endif>Дедлайн</option>
                                                        <option value="list" @if($field->type == 'list') selected @endif>Список</option>
                                                        <option value="file" @if($field->type == 'file') selected @endif>Файл</option>
                                                        <option value="files" @if($field->type == 'files') selected @endif>Файлы</option>
                                                        <option value="image" @if($field->type == 'image') selected @endif>Картинка</option>
                                                        <option value="gallery" @if($field->type == 'gallery') selected @endif>Галерея</option>
                                                        <option value="orm" @if($field->type == 'orm') selected @endif>Связь</option>
                                                        <option value="address" @if($field->type == 'address') selected @endif>Адрес</option>
                                                        <option value="coords" @if($field->type == 'coords') selected @endif>Координаты</option>
                                                        <option value="passwd" @if($field->type == 'passwd') selected @endif>Пароль</option>
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
                                                        <script src="/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
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
                                                        <option value="string">Строка</option>
                                                        <option value="link">Ссылка</option>
                                                        <option value="textarea">Текст</option>
                                                        <option value="text_editor">Редактор</option>
                                                        <option value="date">Дата</option>
                                                        <option value="datetime">Дата и время</option>
                                                        <option value="deadline">Дедлайн</option>
                                                        <option value="list">Список</option>
                                                        <option value="file">Файл</option>
                                                        <option value="files">Файлы</option>
                                                        <option value="image">Картинка</option>
                                                        <option value="gallery">Галерея</option>
                                                        <option value="orm">Связь</option>
                                                        <option value="address">Адрес</option>
                                                        <option value="coords">Координаты</option>
                                                        <option value="passwd">Пароль</option>
                                                        </select>
                                                        <x-input-error class="mt-2" :messages="$errors->get($field.'title')" />
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <x-text-input id="{{$field}}_template" name="fields[{{$field}}][template]" form="data-form" type="text" class="mt-1 block w-full" />
                                                        <x-input-error class="mt-2" :messages="$errors->get($field.'template')" />
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div id="editor"></div>
                                                        <textarea id="{{$field}}_ext"  name="fields[{{$field}}][ext]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                                        <x-input-error class="mt-2" :messages="$errors->get($field.'ext')" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'relations'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="relations-tab">
                                    Отношения
                                    <div class="mb-6">
                                        <div>
                                            <table>
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 w-2/12">
                                                        Слаг
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 w-2/12">
                                                        Имя
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 w-3/12">
                                                        Тип
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 w-2/12">
                                                        Шаблон
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 w-3/12">
                                                        Дополнительно
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
                                                            <option value="hasOne">Один к одному</option>
                                                            <option value="belongsTo">Один к одному(обратное)</option>
                                                            <option value="hasMany">Один ко многим</option>
                                                            <option value="belongsTo">Один ко многим(обратное)</option>
                                                            <option value="belongsToMany">Многие ко многим</option>
                                                            </select>
                                                            <x-input-error class="mt-2" :messages="$errors->get('orm.type')" />
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <x-text-input id="orm_template" name="orm[template]" form="data-form" type="text" class="mt-1 block w-full" />
                                                            <x-input-error class="mt-2" :messages="$errors->get('orm.template')" />
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            Создайте отношение для отображения настроек
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'templates'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    Шаблон выгрузки
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
                                    Виджет на главной
                                </div>
                                <div x-show="currentTab === 'forms'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    Форма
                                    <div class="mb-6">
                                        <div >
                                            <x-input-label for="form_fields" :value="__('Form fields')" />
                                            <x-text-input type="text" id="form_fields" name="data[form_fields]" form="data-form" class="mt-1 block w-full" :value="$resource->form_fields" autofocus autocomplete="form_fields" />
                                            <x-input-error class="mt-2" :messages="$errors->get('form_fields')" />
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <div >
                                            Ссылка на форму: <a href="{{Asset('form/' . strtolower($resource->model_name))}}">{{Asset('form/' . strtolower($resource->model_name))}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'api'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    API
                                    <div class="mb-6">
                                        <div >
                                            <x-input-label for="api_fields" :value="__('API fields')" />
                                            <x-text-input type="text" id="api_fields" name="data[api_fields]" form="data-form" class="mt-1 block w-full" :value="$resource->api_fields" autofocus autocomplete="api_fields" />
                                            <x-input-error class="mt-2" :messages="$errors->get('api_fields')" />
                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'access'" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel" aria-labelledby="profile-tab">
                                    Настройка доступа
                                </div>
                                <div class="flex justify-between">
                                    <a href="{{route('resources.index')}}">
                                        <x-secondary-button class="mt-4">
                                            Назад
                                        </x-secondary-button>
                                    </a>
                                    <x-primary-button type="submit" form="data-form" class="mt-4">
                                        Сохранить
                                    </x-primary-button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-mtm-layout>
