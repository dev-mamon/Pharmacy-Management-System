<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Edit Stock: {{ $stock->medicine->name }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Update stock information
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <a wire:navigate href="{{ route('admin.stocks.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Stock
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Stock Information</h2>
                        <p class="text-sm text-gray-600 mt-1">Update the details for this stock entry.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                            Batch: {{ $stock->batch_number }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form wire:submit.prevent="update">
                    <div class="space-y-6">
                        <!-- Medicine and Branch Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Medicine -->
                            <div>
                                <label for="medicine_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Medicine <span class="text-red-500">*</span>
                                </label>
                                <select id="medicine_id" wire:model="medicine_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition @error('medicine_id') border-red-300 @enderror">
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}"
                                            {{ $medicine->id == $stock->medicine_id ? 'selected' : '' }}>
                                            {{ $medicine->name }} ({{ $medicine->generic_name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('medicine_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Branch -->
                            <div>
                                <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Branch <span class="text-red-500">*</span>
                                </label>
                                <select id="branch_id" wire:model="branch_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition @error('branch_id') border-red-300 @enderror">
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ $branch->id == $stock->branch_id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Batch and Expiry -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Batch Number -->
                            <div>
                                <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-1">
                                    Batch Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="batch_number" wire:model="batch_number"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition @error('batch_number') border-red-300 @enderror"
                                    placeholder="Enter batch number">
                                @error('batch_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Expiry Date -->
                            <div>
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    Expiry Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="expiry_date" wire:model="expiry_date"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition @error('expiry_date') border-red-300 @enderror">
                                @error('expiry_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Prices -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Purchase Price -->
                            <div>
                                <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Purchase Price (৳) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" step="0.01" id="purchase_price" wire:model="purchase_price"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition @error('purchase_price') border-red-300 @enderror"
                                    placeholder="0.00">
                                @error('purchase_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Selling Price -->
                            <div>
                                <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Selling Price (৳) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" step="0.01" id="selling_price" wire:model="selling_price"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition @error('selling_price') border-red-300 @enderror"
                                    placeholder="0.00">
                                @error('selling_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Quantity and Stock Levels -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                    Quantity <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="quantity" wire:model="quantity"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition @error('quantity') border-red-300 @enderror"
                                    placeholder="0">
                                @error('quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Min Stock Level -->
                            <div>
                                <label for="min_stock_level" class="block text-sm font-medium text-gray-700 mb-1">
                                    Minimum Stock Level
                                </label>
                                <input type="number" id="min_stock_level" wire:model="min_stock_level"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                                    placeholder="10">
                            </div>

                            <!-- Reorder Level -->
                            <div>
                                <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-1">
                                    Reorder Level
                                </label>
                                <input type="number" id="reorder_level" wire:model="reorder_level"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                                    placeholder="20">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Last updated: {{ $stock->updated_at->format('M d, Y \a\t h:i A') }}
                        </div>
                        <div class="flex space-x-3">
                            <a wire:navigate href="{{ route('admin.stocks.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Update Stock
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
