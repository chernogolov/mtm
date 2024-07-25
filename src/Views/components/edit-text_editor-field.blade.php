@props([
'disabled' => false,
'name',
'data',
'value'
])

@php $ext = json_decode($data->ext); @endphp

<div class="col-span-2 р-32">
    @if(isset($ext->required))
        <x-trix-input id="editor_{{$name}}" required="required" name="{{$name}}" value="{!! $value !!}" />
    @else
        <x-trix-input id="editor_{{$name}}" name="{{$name}}" value="{!! $value !!}" />
    @endif
</div>