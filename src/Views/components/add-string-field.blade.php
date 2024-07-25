@props([
'disabled' => false,
'name',
'data'
])
@php $ext = json_decode($data->ext); @endphp

<input {{ $disabled ? 'disabled' : '' }}
       name="{{$name}}"
       {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}
@if(isset($ext->required))
    required="required"
@endif
@if(isset($ext->type))
    type="{{$ext->type}}"
@endif
>
