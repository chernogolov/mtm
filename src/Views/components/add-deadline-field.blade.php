@props([
'disabled' => false,
'name',
'data'
])

@php $ext = json_decode($data->ext); @endphp

@php $time = Carbon\Carbon::now()->addDay(30)->startOfDay()->addHours(9)->format('Y-m-d\Th:i:s') @endphp

@if(isset($data->ext['days']))
    @php $time = Carbon\Carbon::now()->addDay($data->ext['days'])->startOfDay()->format('Y-m-d\Th:i:s') @endphp
@elseif(isset($data->ext['hours']))
    @php $time = Carbon\Carbon::now()->addHour($data->ext['hours'])->startOfHour()->format('Y-m-d\Th:i:s') @endphp
@endif

<input type="datetime-local" value="{{$time}}" {{ $disabled ? 'disabled' : '' }} name="{{$name}}" {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}
{{--min="{{Carbon\Carbon::now()->addHour(2)->format('Y-m-d\Th:i:s')}}"--}}
{{--max="{{Carbon\Carbon::now()->addDay(365)->format('Y-m-d\Th:i:s')}}"--}}
@if(isset($ext->required))
    required="required"
@endif
>
