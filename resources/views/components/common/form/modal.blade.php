{{-- resources/views/components/common/form/modal.blade.php --}}
@props(['maxWidth' => 'max-w-2xl', 'title' => null, 'description' => null])

@php
    // preserve Livewire entangle if provided
    $entangle = $attributes->wire('model') ? $attributes->wire('model')->value() : null;
@endphp

<div x-data="{ open: @if ($entangle) @entangle($entangle) @else false @endif }" x-show="open" x-cloak x-trap.noscroll="open" @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-end sm:items-center justify-center" role="dialog" aria-modal="true">

    <!-- Backdrop (click to close) -->
    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-200" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gradient-to-br from-black/20 via-black/30 to-black/40 transition-opacity"
        @click="open = false" aria-hidden="true"></div>

    <!-- Modal panel wrapper to center on page -->
    <div class="flex min-h-screen w-full items-end justify-center p-4 text-center sm:items-center sm:p-6">
        <!-- Panel -->
        <div x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.stop
            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full {{ $maxWidth }} sm:mx-auto flex flex-col"
            role="document" style="max-height: 90vh;">

            <!-- Close Button -->
            <button @click="open = false" type="button"
                class="absolute right-4 top-4 inline-flex items-center justify-center rounded-md bg-white p-1 text-gray-400"
                aria-label="Close modal">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>

            <!-- Header (title + description) -->
            <div class="px-6 pt-6 pb-0 flex-shrink-0">
                <div class="min-w-0">
                    @if ($title)
                        <h3 id="modal-title-{{ \Illuminate\Support\Str::slug($title) }}"
                            class="text-lg font-semibold text-gray-900 leading-tight">
                            {{ $title }}
                        </h3>
                    @endif

                    @if ($description)
                        <p id="modal-desc-{{ \Illuminate\Support\Str::slug($title ?? 'modal') }}"
                            class="mt-1 text-sm text-gray-500">
                            {{ $description }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Body (scrollable when content is tall) -->
            <div class="px-6 py-4 space-y-6 overflow-auto scrollbar-premium"
                style="max-height: calc(90vh - 6rem); -webkit-overflow-scrolling: touch;">
                {{ $slot }}
            </div>

            <!-- Footer (optional) -->
            @if (isset($footer))
                <div class="px-6 pb-6 pt-0 flex-shrink-0">
                    <div class="flex justify-end space-x-3">
                        {{ $footer }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
