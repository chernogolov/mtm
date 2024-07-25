@props([
'disabled' => false,
'name',
'data'
])
<form method="post" action="{{ route('resources.store') }}" class="mt-6 space-y-6">
    @csrf
    <div class="w-full overflow-x-auto mb-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach($data['fields'] as $field)
                    <th scope="col" class="px-6 py-3">
                        {{$field}}
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                @foreach($data['fields'] as $field)
                    <td class="px-6 py-4">
                        <x-text-input id="{{$field}}" name="{{$field}}" type="text" class="mt-1 block w-full" :value="old($field)" required autofocus autocomplete="{{$field}}" />
                        <x-input-error class="mt-2" :messages="$errors->get($field)" />
                    </td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
    <div class="flex justify-between">
        <x-secondary-button>
            Добавить поле
        </x-secondary-button>
        <x-primary-button>
            Сохранить
        </x-primary-button>
    </div>
</form>


