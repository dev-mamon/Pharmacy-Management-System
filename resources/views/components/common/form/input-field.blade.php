@props([
    'label' => null,
    'model' => null,
    'placeholder' => '',
    'type' => 'text',
    'icon' => null,
    'textarea' => false,
    'rows' => 3,
    'help' => null,
    'required' => false,
])

@php
    $wireModel = $attributes->get('wire:model') ?? $model;
    // render
    $inputId = $attributes->get('id') ?? 'input-' . \Illuminate\Support\Str::slug($label ?? ($model ?? uniqid()));
@endphp

<div class="w-full">
    {{-- Label with asterisk if required --}}
    @if ($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-900 mb-1">
            {{ $label }}
            @if ($required)
                <span aria-hidden="true" class="text-red-500 ml-1">*</span>
                <span class="sr-only"> (required)</span>
            @endif
        </label>
    @endif

    <div class="relative flex items-center">
        @if ($icon)
            <span class="absolute left-3 text-gray-400 pointer-events-none">
                {!! $icon !!}
            </span>
        @endif

        @if ($textarea)
            <textarea id="{{ $inputId }}" @if ($wireModel) wire:model="{{ $wireModel }}" @endif
                placeholder="{{ $placeholder }}" rows="{{ $rows }}"
                @if ($required) required aria-required="true" @endif
                {{ $attributes->merge([
                    'class' =>
                        'block w-full px-4 py-2 text-gray-700 bg-white border border-gray-200 rounded-lg
                                                                      focus:border-indigo-500 focus:ring-1 focus:ring-indigo-300 focus:outline-none' .
                        ($icon ? 'pl-10' : ''),
                ]) }}>{{ $slot }}</textarea>
        @else
            <input id="{{ $inputId }}" type="{{ $type }}"
                @if ($wireModel) wire:model="{{ $wireModel }}" @endif
                placeholder="{{ $placeholder }}"
                @if ($required) required aria-required="true" @endif
                {{ $attributes->merge([
                    'class' =>
                        'block w-full px-4 py-2 text-gray-700 bg-white border border-gray-200 rounded-lg
                                                                      focus:border-indigo-500 focus:ring-1 focus:ring-indigo-300 focus:outline-none' .
                        ($icon ? 'pl-10' : ''),
                ]) }} />
        @endif
    </div>

    @if ($help)
        <p class="mt-1 text-xs text-gray-500">{{ $help }}</p>
    @endif

    @if ($wireModel)
        @error($wireModel)
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    @endif
</div>
