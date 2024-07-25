@props(['data', 'value', 'field'])

@php $ext = json_decode($field->ext); $list = []; @endphp

@if(isset($ext->list))
    {{$ext->list->$value}}
@endif
