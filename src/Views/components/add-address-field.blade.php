@props([
'disabled' => false,
'name',
'data'
])
@php $ext = json_decode($data->ext); @endphp

<input {{ $disabled ? 'disabled' : '' }} id="adr_{{$name}}" name="{{$name}}" {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}
@if(isset($ext->required))
    required="required"
@endif
>

{{--<script>--}}

{{--    var inputTextField = document.getElementById('adr_{{$name}}')--}}
{{--    // var outputTextField = document.getElementById('textResult')--}}

{{--    inputTextField.oninput = function()--}}
{{--    {--}}
{{--        var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address";--}}
{{--        var token = "41e7e24cfa4f5c8d89e4df0198ece01c5107a486";--}}
{{--        var query = inputTextField.value;--}}
{{--        var options = {--}}
{{--            method: "POST",--}}
{{--            mode: "cors",--}}
{{--            headers: {--}}
{{--                "Content-Type": "application/json",--}}
{{--                "Accept": "application/json",--}}
{{--                "Authorization": "Token " + token--}}
{{--            },--}}
{{--            body: JSON.stringify({query: query})--}}
{{--        }--}}

{{--        fetch(url, options)--}}
{{--            .then(response => response.text())--}}
{{--            .then(result => console.log(result))--}}
{{--            .catch(error => console.log("error", error));--}}
{{--        // outputTextField.value = inputTextField.value--}}
{{--    }--}}
{{--</script>--}}