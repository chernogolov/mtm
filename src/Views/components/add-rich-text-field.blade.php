@props([
'disabled' => false,
'name',
'data'
])

@php $ext = json_decode($data->ext); @endphp

<div class="col-span-2 р-32">
    <x-trix-input id="editor_{{$name}}" name="{{$name}}" value=""
                  @if(isset($ext->required))
                    required="required"
                  @endif
    />
</div>
