@props([
'disabled' => false,
'name',
'data',
'value'
])

<input type="datetime-local" value="{{Carbon\Carbon::parse($value)->format('Y-m-d\Th:i:s')}}" {{ $disabled ? 'disabled' : '' }} name="{{$name}}" {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}
{{--min="{{Carbon\Carbon::now()->addHour(2)->format('Y-m-d\Th:i:s')}}"--}}
{{--max="{{Carbon\Carbon::now()->addDay(365)->format('Y-m-d\Th:i:s')}}"--}}
>
