<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Generate Barcode
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Generate new barcode for medicines
                </p>
            </div>

            <div>
                <a wire:navigate href="{{ route('admin.medicine.barcode') }}"
                    class="bg-gray-100 text-gray-700 hover:bg-gray-200 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Back to List</span>
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
            <form wire:submit.prevent="save" class="p-6">
                <div class="space-y-6">
                    <!-- Medicine Selection -->
                    <div>
                        <label for="medicine_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Medicine *
                        </label>
                        <select wire:model.live="medicine_id" id="medicine_id"
                            class="w-full h-11 pl-3 pr-10 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 @error('medicine_id') border-red-500 @enderror">
                            <option value="">-- Select Medicine --</option>
                            @foreach ($medicines as $medicine)
                                <option value="{{ $medicine->id }}">
                                    {{ $medicine->name }} - {{ $medicine->generic_name }}
                                    @if ($medicine->strength)
                                        ({{ $medicine->strength }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('medicine_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Barcode Settings -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Barcode Type -->
                        <div>
                            <label for="barcode_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Barcode Type *
                            </label>
                            <select wire:model.live="barcode_type" id="barcode_type"
                                class="w-full h-11 pl-3 pr-10 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                                @foreach ($barcodeTypes as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity *
                            </label>
                            <input type="number" wire:model.live="quantity" id="quantity" min="1"
                                max="100"
                                class="w-full h-11 px-3 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 @error('quantity') border-red-500 @enderror">
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Number of barcodes to generate (Max: 100)</p>
                        </div>
                    </div>

                    <!-- Custom Barcode Option -->
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.live="use_custom" id="use_custom"
                                class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="use_custom" class="ml-2 block text-sm text-gray-700">
                                Use Custom Barcode
                            </label>
                        </div>

                        @if ($use_custom)
                            <div>
                                <label for="custom_barcode" class="block text-sm font-medium text-gray-700 mb-2">
                                    Custom Barcode
                                </label>
                                <input type="text" wire:model.live="custom_barcode" id="custom_barcode"
                                    class="w-full h-11 px-3 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 @error('custom_barcode') border-red-500 @enderror">
                                @error('custom_barcode')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Preview Section -->
                    @if (!empty($generatedBarcodes))
                        <div class="border border-gray-200 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Preview</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($generatedBarcodes as $preview)
                                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                                        <div class="mb-3">
                                            <img src="data:image/png;base64,{{ $preview['image'] }}"
                                                alt="{{ $preview['value'] }}" class="mx-auto h-20">
                                        </div>
                                        <div class="font-mono text-sm font-medium text-gray-900">
                                            {{ $preview['value'] }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $barcode_type }}
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            @if ($quantity > 5)
                                <div class="text-center text-gray-500 text-sm mt-4">
                                    <i class="fas fa-ellipsis-h"></i> And {{ $quantity - 5 }} more barcodes will be
                                    generated
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="$dispatch('refresh')"
                            class="flex-1 sm:flex-none bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-redo mr-2"></i>
                            Refresh Preview
                        </button>
                        <button type="submit"
                            class="flex-1 sm:flex-none bg-orange-500 text-white hover:bg-orange-600 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            @if (!$medicine_id) disabled @endif>
                            <i class="fas fa-barcode mr-2"></i>
                            Generate Barcode{{ $quantity > 1 ? 's' : '' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
