<button
    {{ $attributes->merge([
        'class' => 'px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 transition',
    ]) }}>
    {{ $slot }}
</button>
