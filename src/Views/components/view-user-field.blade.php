@props(['data', 'value', 'name'])

@if($value->user)
    {{$value->user->name}}
@endif