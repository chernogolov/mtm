@props([
'disabled' => false,
'name',
'data',
'value'
])
<input type="hidden" {{ $disabled ? 'disabled' : '' }} name="{{$name}}" value="{{Auth::user()->id}}" {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
<p>
    {{App\Models\User::find($value)->name}}
</p>