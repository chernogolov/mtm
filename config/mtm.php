<?php

return [

    /*
    |--------------------------------------------------------------------------
    | List of resources
    |--------------------------------------------------------------------------
    |
    |
    */

    'resources' => [
        'name' => 'Resources',
        'one_name' => 'Resource',
        'route_prefix' => 'resources',
        'view_prefix' => 'resource',
        'model_name' => 'Resource',
        'fields' =>
            [
                'name'              =>      ['title' => 'Имя', 'type' => 'string', 'required' => true, 'validation' => 'required|string'],
                'one_name'          =>      ['title' => 'Ед.число', 'type' => 'string', 'validation' => 'required|string'],
                'route_prefix'      =>      ['title' => 'Маршруты', 'type' => 'string', 'validation' => 'required|string', 'required' => true],
                'view_prefix'       =>      ['title' => 'Представления', 'type' => 'string', 'validation' => 'required|string', 'required' => true],
                'model_name'        =>      ['title' => 'Имя модели', 'type' => 'string', 'validation' => 'required|string', 'required' => true],
                'fields'            =>      ['title' => 'Поля', 'type' => 'array', 'required' => true, 'multiselect' => true, 'fields' => ['title', 'type', 'required', 'multiselect', 'validation']],
                'catalog_fields'    =>      ['title' => 'Отображаемые поля', 'type' => 'list', 'validation' => 'required|string', 'required' => true, 'multiselect' => true, 'source' => 'editable_fields'],
                'editable_fields'   =>      ['title' => 'Редактируемые поля', 'required' => true, 'validation' => 'required|string', 'type' => 'fields'],
                'form_fields'       =>      ['title' => 'Поля формы', 'required' => false, 'validation' => 'required|string', 'type' => 'fields'],
                'api_fields'        =>      ['title' => 'Поля API', 'required' => false, 'validation' => 'required|string', 'type' => 'fields'],
            ],
        'editable_fields' => ['name', 'one_name', 'route_prefix', 'view_prefix', 'model_name', 'fields', 'editable_fields', 'catalog_fields'],
        'catalog_fields' => ['name', 'model_name', 'route_prefix', 'view_prefix'],

    ],
];
