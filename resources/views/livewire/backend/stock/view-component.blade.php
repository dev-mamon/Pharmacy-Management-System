<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Stock Details: {{ $stock->medicine->name }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    View complete stock information
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <a wire:navigate href="{{ route('admin.stocks.edit', $stock->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Stock
                </a>
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

        <!-- Stock Details Card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Stock Information</h2>
                        <p class="text-sm text-gray-600 mt-1">Detailed view of stock entry.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Stock Status Badge -->
                        @if ($stock->isOutOfStock())
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        @elseif($stock->isLowStock())
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                                Low Stock
                            </span>
                        @elseif($stock->isExpiringSoon())
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                Expiring Soon
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                In Stock
                            </span>
                        @endif
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                            Batch: {{ $stock->batch_number }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Medicine Information -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Medicine Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Medicine Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stock->medicine->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Generic Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stock->medicine->generic_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Medicine Type</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stock->medicine->medicine_type ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Branch Information -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Branch Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Branch Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stock->branch->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Branch Code</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stock->branch->code ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Branch Address</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stock->branch->address ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Stock Details -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Stock Details</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Batch Number</label>
                                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $stock->batch_number }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Expiry Date</label>
                                        <p
                                            class="mt-1 text-sm {{ $stock->isExpired() ? 'text-red-600 font-semibold' : ($stock->isExpiringSoon() ? 'text-orange-600' : 'text-gray-900') }}">
                                            {{ $stock->expiry_date->format('M d, Y') }}
                                            @if ($stock->isExpired())
                                                <span class="text-xs text-red-500">(Expired)</span>
                                            @elseif($stock->isExpiringSoon())
                                                <span class="text-xs text-orange-500">(Expiring Soon)</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Current Quantity</label>
                                        <p
                                            class="mt-1 text-sm font-semibold {{ $stock->isOutOfStock() ? 'text-red-600' : ($stock->isLowStock() ? 'text-orange-600' : 'text-gray-900') }}">
                                            {{ $stock->quantity }}
                                            @if ($stock->isLowStock() && !$stock->isOutOfStock())
                                                <span class="text-xs text-orange-500">(Low Stock)</span>
                                            @endif
                                            @if ($stock->isOutOfStock())
                                                <span class="text-xs text-red-500">(Out of Stock)</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Reorder Level</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $stock->reorder_level }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Information -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Price Information</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Purchase Price</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            ৳{{ number_format($stock->purchase_price, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Selling Price</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            ৳{{ number_format($stock->selling_price, 2) }}</p>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Profit Margin</label>
                                    @php
                                        $profit = $stock->selling_price - $stock->purchase_price;
                                        $margin =
                                            $stock->purchase_price > 0 ? ($profit / $stock->purchase_price) * 100 : 0;
                                    @endphp
                                    <p class="mt-1 text-sm {{ $margin > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        ৳{{ number_format($profit, 2) }} ({{ number_format($margin, 2) }}%)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Levels -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Stock Levels</h3>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Current Stock
                                        Level</label>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        @php
                                            $maxLevel = max($stock->quantity, $stock->reorder_level * 2);
                                            $percentage = $maxLevel > 0 ? ($stock->quantity / $maxLevel) * 100 : 0;
                                            $color = $stock->isOutOfStock()
                                                ? 'bg-red-600'
                                                : ($stock->isLowStock()
                                                    ? 'bg-orange-600'
                                                    : 'bg-green-600');
                                        @endphp
                                        <div class="h-2.5 rounded-full {{ $color }}"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                                        <span>0</span>
                                        <span>{{ $stock->reorder_level }} (Reorder)</span>
                                        <span>{{ $maxLevel }}</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Minimum Stock
                                            Level</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $stock->min_stock_level }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Days Until Expiry</label>
                                        <p
                                            class="mt-1 text-sm {{ $stock->isExpiringSoon() ? 'text-orange-600' : 'text-gray-900' }}">
                                            {{ max(0, now()->diffInDays($stock->expiry_date, false)) }} days
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Created At</label>
                            <p class="mt-1">{{ $stock->created_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Last Updated</label>
                            <p class="mt-1">{{ $stock->updated_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
