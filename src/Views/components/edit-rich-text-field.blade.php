@props([
'disabled' => false,
'name',
'data',
'value'
])
<div class="col-span-2 р-32">
    <x-trix-input id="editor_{{$name}}" name="{{$name}}" value="{{$value}}" />
</div>
