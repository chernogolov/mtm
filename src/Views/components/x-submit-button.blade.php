<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold uppercase tracking-widest focus:outline-none  transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
