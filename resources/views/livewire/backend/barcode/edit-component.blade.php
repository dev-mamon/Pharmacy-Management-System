<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Edit Barcode
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Update barcode information
                </p>
            </div>

            <div>
                <a wire:navigate href="{{ route('admin.medicine.barcode.view', $barcodeId) }}"
                    class="bg-gray-100 text-gray-700 hover:bg-gray-200 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Back to View</span>
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('message') }}
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
                        <select wire:model="medicine_id" id="medicine_id"
                            class="w-full h-11 pl-3 pr-10 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 @error('medicine_id') border-red-500 @enderror">
                            <option value="">-- Select Medicine --</option>
                            @foreach ($this->medicines as $medicine)
                                <option value="{{ $medicine->id }}"
                                    {{ $medicine_id == $medicine->id ? 'selected' : '' }}>
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
                        <!-- Barcode Number -->
                        <div>
                            <label for="barcode" class="block text-sm font-medium text-gray-700 mb-2">
                                Barcode Number *
                            </label>
                            <input type="text" wire:model="barcode" id="barcode"
                                class="w-full h-11 px-3 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 @error('barcode') border-red-500 @enderror"
                                placeholder="Enter barcode number">
                            @error('barcode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Barcode Type -->
                        <div>
                            <label for="barcode_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Barcode Type *
                            </label>
                            <select wire:model="barcode_type" id="barcode_type"
                                class="w-full h-11 pl-3 pr-10 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                                @foreach ($this->barcodeTypes as $key => $type)
                                    <option value="{{ $key }}" {{ $barcode_type == $key ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" wire:model="is_active" id="is_active" class="sr-only"
                                    {{ $is_active ? 'checked' : '' }}>
                                <div
                                    class="block w-14 h-8 rounded-full {{ $is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                </div>
                                <div
                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition transform {{ $is_active ? 'translate-x-6' : '' }}">
                                </div>
                            </div>
                            <div class="ml-3 text-gray-700 font-medium text-sm">
                                {{ $is_active ? 'Active' : 'Inactive' }}
                            </div>
                        </label>
                        <p class="mt-1 text-xs text-gray-500">
                            Active barcodes will be available for scanning
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <a wire:navigate href="{{ route('admin.medicine.barcode') }}"
                            class="flex-1 sm:flex-none bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors text-center">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex-1 sm:flex-none bg-orange-500 text-white hover:bg-orange-600 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Update Barcode
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .dot {
            transition: all 0.3s ease-in-out;
        }
    </style>
</main>
