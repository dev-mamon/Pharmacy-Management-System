<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Create Sales Return
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Process return for sold items
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a wire:navigate href="{{ route('admin.returns.index') }}"
                    class="bg-white text-gray-700 hover:bg-gray-50 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Back to Returns</span>
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Return Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Branch and Sale Selection Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Select Branch & Sale</h2>

                    <!-- Branch Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Branch *</label>
                        <select wire:model.live="branchId"
                            class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Select a Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        @error('branchId')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Search -->
                    @if ($branchId)
                        <div x-data="{
                            open: @entangle('showSaleSearch'),
                            init() {
                                this.$watch('open', (value) => {
                                    if (value) {
                                        this.$nextTick(() => {
                                            const input = this.$refs.saleSearchInput;
                                            if (input) input.focus();
                                        });
                                    }
                                });
                        
                                // Handle outside clicks
                                window.addEventListener('click', (e) => {
                                    if (this.open && !this.$el.contains(e.target)) {
                                        this.open = false;
                                        @this.set('showSaleSearch', false);
                                    }
                                });
                            }
                        }" class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Sale *</label>

                            <!-- Search Input with Clear Button -->
                            <div class="relative">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" wire:model.live="saleSearch" x-ref="saleSearchInput"
                                    @click="open = true" @focus="open = true"
                                    class="w-full pl-10 pr-10 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                    placeholder="Click to search completed sales..." autocomplete="off">

                                <!-- Clear Button -->
                                @if ($saleSearch)
                                    <button type="button" wire:click="$set('saleSearch', '')" @click.stop
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                @endif

                                <!-- Dropdown Toggle Button -->
                                <button type="button" @click="open = !open"
                                    class="absolute right-10 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-chevron-down text-sm"
                                        :class="{ 'transform rotate-180': open }"></i>
                                </button>
                            </div>

                            <!-- Sale Search Results Dropdown -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-80 overflow-y-auto"
                                style="display: none;">
                                <!-- Search Header -->
                                <div class="sticky top-0 bg-white border-b border-gray-200 px-4 py-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium text-gray-700">Completed Sales</span>
                                        <button type="button" @click="open = false"
                                            class="text-xs text-gray-500 hover:text-gray-700">
                                            Close
                                        </button>
                                    </div>
                                </div>

                                <!-- Loading State -->
                                @if ($saleSearch && !$filteredSales)
                                    <div class="px-4 py-8 text-center">
                                        <div
                                            class="animate-spin rounded-full h-6 w-6 border-b-2 border-orange-500 mx-auto">
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">Searching...</p>
                                    </div>
                                @endif

                                <!-- Results -->
                                @if ($filteredSales && $filteredSales->count() > 0)
                                    @foreach ($filteredSales as $sale)
                                        <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
                                            wire:click="selectSale({{ $sale->id }})" @click="open = false">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <div class="font-medium text-gray-900 truncate">
                                                            {{ $sale->invoice_number }}
                                                        </div>
                                                        <span
                                                            class="px-1.5 py-0.5 text-xs bg-green-100 text-green-800 rounded">
                                                            Completed
                                                        </span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mb-1">
                                                        <div class="flex items-center gap-2">
                                                            <i class="fas fa-user text-gray-400"></i>
                                                            <span>{{ $sale->customer->name ?? 'Walk-in Customer' }}</span>
                                                        </div>
                                                        <div class="flex items-center gap-2 mt-1">
                                                            <i class="far fa-calendar text-gray-400"></i>
                                                            <span>{{ $sale->sale_date->format('d M, Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ml-4 text-right">
                                                    <div class="text-sm font-semibold text-gray-900 whitespace-nowrap">
                                                        ৳{{ number_format($sale->grand_total, 2) }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $sale->items->count() }} items
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @elseif($showSaleSearch && (!$saleSearch || $filteredSales->count() === 0))
                                    <div class="px-4 py-8 text-center text-gray-500">
                                        <svg class="w-10 h-10 mx-auto text-gray-400 mb-3" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        @if ($saleSearch)
                                            <p class="text-sm font-medium text-gray-900 mb-1">No sales found</p>
                                            <p class="text-xs">Try a different search term</p>
                                        @else
                                            <p class="text-sm font-medium text-gray-900 mb-1">No recent sales</p>
                                            <p class="text-xs">Start typing to search sales</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            @error('saleId')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Selected Sale Details -->
                    @if ($sale)
                        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="font-semibold text-gray-900">{{ $sale->invoice_number }}</div>
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                            <i class="fas fa-check mr-1"></i>Completed
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <div class="text-gray-600">Customer</div>
                                            <div class="font-medium">{{ $sale->customer->name ?? 'Walk-in Customer' }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-gray-600">Sale Date</div>
                                            <div>{{ $sale->sale_date->format('d M, Y') }}</div>
                                        </div>
                                        <div>
                                            <div class="text-gray-600">Total Amount</div>
                                            <div class="font-semibold">৳{{ number_format($sale->grand_total, 2) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-gray-600">Items</div>
                                            <div>{{ $sale->items->count() }} items</div>
                                        </div>
                                    </div>
                                </div>
                                <button wire:click="resetSaleSelection" type="button"
                                    class="ml-4 text-red-600 hover:text-red-800 p-1 rounded-full hover:bg-red-50">
                                    <i class="fas fa-times text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sale Items Selection Card -->
                @if ($sale && $saleItems->count() > 0)
                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 mb-1">Select Items to Return</h2>
                                <p class="text-sm text-gray-600">Select items from the sale to process return</p>
                            </div>
                            <div class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                <span class="font-medium text-gray-900">{{ count($selectedItems) }}</span> item(s)
                                selected
                            </div>
                        </div>

                        @if (count($selectedItems) === 0)
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-gray-900 font-medium mb-2">No items selected</p>
                                <p class="text-sm text-gray-600 mb-4">Select items from the list below to process
                                    return</p>
                            </div>
                        @endif

                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr class="text-xs font-semibold text-gray-600 uppercase">
                                        <th class="px-4 py-3 text-left w-10">
                                            <span class="sr-only">Select</span>
                                        </th>
                                        <th class="px-4 py-3 text-left">Medicine</th>
                                        <th class="px-4 py-3 text-left text-center">Sold</th>
                                        <th class="px-4 py-3 text-left text-center">Returned</th>
                                        <th class="px-4 py-3 text-left text-center">Available</th>
                                        <th class="px-4 py-3 text-left">Return Qty</th>
                                        <th class="px-4 py-3 text-left">Unit Price</th>
                                        <th class="px-4 py-3 text-left">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($saleItems as $item)
                                        @php
                                            $isSelected = in_array($item->id, $selectedItems);
                                            $returnItem = $returnItems[$item->id] ?? null;
                                            $maxReturnable = $item->remaining_quantity;
                                            $canReturn = $maxReturnable > 0;
                                        @endphp
                                        <tr
                                            class="{{ $isSelected ? 'bg-blue-50' : '' }} {{ !$canReturn ? 'opacity-50' : '' }}">
                                            <td class="px-4 py-3">
                                                <input type="checkbox" wire:model="selectedItems"
                                                    value="{{ $item->id }}" {{ !$canReturn ? 'disabled' : '' }}
                                                    class="rounded border-gray-300 text-orange-600 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed" />
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->medicine->name }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $item->medicine->generic_name }}
                                                    @if ($item->batch_number)
                                                        • Batch: {{ $item->batch_number }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600 text-center">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600 text-center">
                                                <span
                                                    class="{{ $item->returned_quantity > 0 ? 'text-orange-600 font-medium' : '' }}">
                                                    {{ $item->returned_quantity }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                                    {{ $maxReturnable > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $maxReturnable }}
                                                    @if ($maxReturnable <= 0)
                                                        <i class="fas fa-ban ml-1"></i>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($isSelected)
                                                    <div class="flex items-center gap-2 max-w-xs">
                                                        <button type="button"
                                                            wire:click="updateReturnQuantity({{ $item->id }}, {{ max(1, $returnItem['return_quantity'] - 1) }})"
                                                            class="w-7 h-7 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                                            {{ $returnItem['return_quantity'] <= 1 ? 'disabled' : '' }}>
                                                            <svg class="w-3.5 h-3.5" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M20 12H4" />
                                                            </svg>
                                                        </button>
                                                        <input type="number"
                                                            wire:model.live="returnItems.{{ $item->id }}.return_quantity"
                                                            wire:change="calculateTotal" min="1"
                                                            max="{{ $maxReturnable }}"
                                                            class="w-20 px-2 py-1.5 text-sm text-center border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-orange-500" />
                                                        <button type="button"
                                                            wire:click="updateReturnQuantity({{ $item->id }}, {{ min($maxReturnable, $returnItem['return_quantity'] + 1) }})"
                                                            class="w-7 h-7 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                                            {{ $returnItem['return_quantity'] >= $maxReturnable ? 'disabled' : '' }}>
                                                            <svg class="w-3.5 h-3.5" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M12 4v16m8-8H4" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1 text-center">
                                                        Max: <span class="font-medium">{{ $maxReturnable }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                ৳{{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                @if ($isSelected)
                                                    ৳{{ number_format($returnItem['total_amount'] ?? 0, 2) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if (count($saleItems->where('remaining_quantity', '<=', 0)) > 0)
                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-center text-sm text-yellow-700">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <span>Some items cannot be returned as they have already been fully returned</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Return Details Card -->
                @if (count($selectedItems) > 0)
                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Details</h2>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Return Date *</label>
                                <div class="relative max-w-xs">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="far fa-calendar text-gray-400"></i>
                                    </div>
                                    <input type="date" wire:model="returnDate"
                                        class="pl-10 w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                                </div>
                                @error('returnDate')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Reason for Return *
                                    <span class="text-xs text-gray-500 ml-1">(Min. 10 characters)</span>
                                </label>
                                <textarea wire:model="reason" rows="4"
                                    class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 placeholder-gray-400"
                                    placeholder="Please provide the reason for return (e.g., damaged product, wrong item, customer changed mind, expired, etc.)..."></textarea>
                                <div class="mt-1 flex justify-between text-xs">
                                    <span class="text-gray-500">Required for return processing</span>
                                    <span class="{{ strlen($reason) < 10 ? 'text-red-500' : 'text-green-500' }}">
                                        {{ strlen($reason) }}/10
                                    </span>
                                </div>
                                @error('reason')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                                <textarea wire:model="notes" rows="3"
                                    class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 placeholder-gray-400"
                                    placeholder="Any additional notes for reference (optional)..."></textarea>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Summary -->
            <div class="space-y-6">
                <!-- Return Summary Card -->
                @if (count($selectedItems) > 0)
                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Summary</h2>

                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Selected Items</span>
                                        <span class="font-medium text-gray-900">
                                            {{ count($selectedItems) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Total Quantity</span>
                                        <span class="font-medium text-gray-900">
                                            {{ collect($returnItems)->sum('return_quantity') }}
                                        </span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-base font-semibold text-gray-900">Total Amount</span>
                                            <span class="text-xl font-bold text-red-600">
                                                ৳{{ number_format($totalAmount, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Items List -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Selected Items</h3>
                                <div class="space-y-2 max-h-60 overflow-y-auto">
                                    @foreach ($returnItems as $itemId => $item)
                                        <div class="flex items-start justify-between p-2 bg-gray-50 rounded">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $item['medicine_name'] }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Qty: {{ $item['return_quantity'] }} ×
                                                    ৳{{ number_format($item['unit_price'], 2) }}
                                                </div>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900 ml-2 whitespace-nowrap">
                                                ৳{{ number_format($item['total_amount'], 2) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                        <div class="space-y-3">
                            <button type="button" wire:click="createReturn" wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-not-allowed"
                                class="w-full bg-red-500 text-white hover:bg-red-600 active:scale-[0.98] transition-all duration-200 py-3 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 shadow-sm hover:shadow">
                                <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                </svg>
                                <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span wire:loading.remove>Process Return</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button type="button" wire:click="resetForm"
                                class="w-full bg-gray-100 text-gray-700 hover:bg-gray-200 active:scale-[0.98] transition-all duration-200 py-3 rounded-lg text-sm font-medium">
                                Reset Form
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                            <p class="mb-2 font-medium text-gray-900">Ready to Process Return</p>
                            <p class="text-sm text-gray-600 mb-4">Select a branch, search for a completed sale, and
                                choose items to return.</p>
                            <div class="text-xs text-gray-500 space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span>Only completed sales are available</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span>Click search box to view all sales</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Instructions Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <h3 class="font-medium text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-orange-500"></i>
                        <span>Instructions</span>
                    </h3>
                    <ul class="text-sm text-gray-600 space-y-3">
                        <li class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-xs font-medium text-blue-600">1</span>
                            </div>
                            <span>Select the <strong>branch</strong> where the original sale occurred</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-xs font-medium text-blue-600">2</span>
                            </div>
                            <span><strong>Search</strong> for the completed sale by invoice number or customer
                                name</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-xs font-medium text-blue-600">3</span>
                            </div>
                            <span><strong>Select items</strong> to return and specify quantities (only available
                                quantities)</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-xs font-medium text-blue-600">4</span>
                            </div>
                            <span>Provide a <strong>reason</strong> for the return (required)</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-5 h-5 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-check text-xs text-green-600"></i>
                            </div>
                            <span class="text-green-600"><strong>Stock will be automatically updated</strong> upon
                                return completion</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                // Handle outside click for sale search dropdown
                window.addEventListener('click', function(e) {
                    const saleSearchContainer = document.querySelector('[x-data]');
                    const saleSearchInput = document.querySelector('input[x-ref="saleSearchInput"]');

                    if (saleSearchContainer && saleSearchInput) {
                        const isClickInside = saleSearchContainer.contains(e.target);
                        const isClickOnInput = saleSearchInput.contains(e.target);

                        if (!isClickInside && !isClickOnInput) {
                            // Close dropdown if clicked outside
                            Alpine.store('saleSearchOpen', false);
                            Livewire.dispatch('close-sale-search');
                        }
                    }
                });

                // Listen for keyboard escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        Livewire.dispatch('close-sale-search');
                    }
                });
            });
        </script>
    @endpush
</main>
