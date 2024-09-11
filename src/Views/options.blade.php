<x-mtm-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Options') }}
                            </h2>
                        </header>

                        <form method="post" action="{{ route('options') }}" class="mt-6 space-y-6">
                            @csrf
                            @foreach($data as $key => $value)
                                @php $name = 'options['.$key.']' @endphp
                                <div>
                                    <x-input-label for="{{$key}}" :value="__($key)" />
                                    <x-text-input id="$key" class="mt-1 block w-full" type="text" :name="$name" autocomplete="$key" :value="$value" autofocus :object="$key" :res="$value"/>
                                    <x-input-error class="mt-2" :messages="$errors->get($key)" />
                                </div>
                            @endforeach
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'options-updated')
                                    <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-mtm-layout>
