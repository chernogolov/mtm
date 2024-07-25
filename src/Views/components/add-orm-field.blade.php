@props([
'disabled' => false,
'name',
'data'
])
<input {{ $disabled ? 'disabled' : '' }} name="{{$name . "_id"}}" @if(isset($_GET[$name])) value="{{$_GET[$name]}}" @endif {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
