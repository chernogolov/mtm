@props([
'disabled' => false,
'name',
'data'
])

@php $ext = json_decode($data->ext); @endphp

<div class="col-span-2 р-32">
    @if(isset($ext->required))
        <x-trix-input id="editor_{{$name}}" required="required" name="{{$name}}" value=""/>
    @else
        <x-trix-input id="editor_{{$name}}" name="{{$name}}" value=""/>
    @endif
</div>
