<x-guest-layout>
    <div class="py-4">
        <form method="POST" action="{{ route('form', ['resource' => strtolower($resource->model_name)]) }}" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html">
            @csrf
            @foreach(explode(',', $resource->form_fields) as $field)
                <div class="mb-6 w-full">
                    <label class="text-gray-700">
                        {{$resource->fields->$field->title}}
                    </label>
                    <div class="w-full">
                        @if(isset($data->template))
                            <x-dynamic-component :component="'add-'.$resource->fields->$field->template.'-field'" class="w-full" :name="$field" :data="$resource->fields->$field"/>
                        @elseif(View::exists('components.user-'.$resource->fields->$field->type.'-field'))
                            <x-dynamic-component :component="'user-'.$resource->fields->$field->type.'-field'" class="w-full" :name="$field" :data="$resource->fields->$field"/>
                        @else
                            <x-dynamic-component :component="'add-'.$resource->fields->$field->type.'-field'" class="w-full" :name="$field" :data="$resource->fields->$field"/>
                        @endif
                    </div>
                    @error($field)
                    <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
            <x-primary-button type="submit" class="mt-2">
                Отправить
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>