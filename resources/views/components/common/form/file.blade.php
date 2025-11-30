@props([
    'model' => 'image',
    'label' => 'File',
    // default accept allows images, videos and PDFs; override when using component
    'accept' => 'image/*,video/*,application/pdf',
    'preview' => null,
])

@php
    $file = data_get($this, $model);
    $previewPath = $preview ?? data_get($this, $model . 'Preview');

    $fileUrl = null;
    $mime = null;

    if ($file) {
        // temporary upload (Livewire temporaryUploadedFile)
        try {
            $fileUrl = $file->temporaryUrl();
            $mime = $file->getMimeType();
        } catch (\Throwable $e) {
            $fileUrl = null;
            $mime = null;
        }
    } elseif ($previewPath) {
        // stored path (like "categories/images/xxx.jpg")
        $fileUrl = \Illuminate\Support\Facades\Storage::url($previewPath);

        // try to guess mime from extension if you don't store mime in DB
    $ext = pathinfo($previewPath, PATHINFO_EXTENSION);
    $ext = strtolower($ext);
    $map = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'ogg' => 'video/ogg',
        'pdf' => 'application/pdf',
        ];
        $mime = $map[$ext] ?? null;
    }
@endphp

<div class="flex-1 min-w-[200px]">
    <label class="block mb-1 text-sm font-medium text-gray-700">{{ $label }}</label>

    <div x-data="{ drag: false }" x-on:dragover.prevent="drag = true" x-on:dragleave.prevent="drag = false"
        x-on:drop.prevent="drag = false" :class="drag ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300 bg-gray-50'"
        class="border-2 border-dashed rounded-lg p-4 cursor-pointer text-center">

        <input type="file" wire:model="{{ $model }}" accept="{{ $accept }}" class="hidden"
            x-ref="{{ $model }}Input">
        <p class="text-sm text-gray-700" @click="$refs.{{ $model }}Input.click()">Drop or browse</p>

        @if ($fileUrl)
            <div class="mt-3 relative inline-block max-w-full">
                @if (str_contains($mime, 'image'))
                    <img src="{{ $fileUrl }}" class="w-40 h-40 object-cover rounded"
                        alt="{{ $label }} preview">
                @elseif (str_contains($mime, 'video'))
                    <video controls class="w-60 h-auto rounded max-w-full" preload="metadata">
                        <source src="{{ $fileUrl }}" type="{{ $mime }}">
                        Your browser does not support the video tag.
                    </video>
                @elseif ($mime === 'application/pdf' || str_ends_with($fileUrl, '.pdf'))
                    {{-- iframe/embed for PDFs --}}
                    <div class="w-80 h-96 border rounded overflow-hidden">
                        <iframe src="{{ $fileUrl }}" class="w-full h-full" frameborder="0"></iframe>
                    </div>
                @else
                    {{-- fallback: show link --}}
                    <a href="{{ $fileUrl }}" target="_blank" class="inline-block mt-2 text-sm underline">
                        Open file
                    </a>
                @endif

                {{-- Delete/Clear button --}}
                @if ($file)
                    <button type="button" wire:click="$set('{{ $model }}', null)"
                        class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow">
                        ✕
                    </button>
                @else
                    <button type="button" wire:click="$set('{{ $model }}Preview', null)"
                        class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow">
                        ✕
                    </button>
                @endif
            </div>
        @endif

    </div>

    @error($model)
        <span class="text-red-600 text-xs mt-1">{{ $message }}</span>
    @enderror
</div>
