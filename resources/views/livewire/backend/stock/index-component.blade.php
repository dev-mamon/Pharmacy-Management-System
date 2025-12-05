<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Stock Management
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Manage and monitor your pharmacy stock levels
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                @if (count($selectedStocks) > 0)
                    <button wire:click="deleteSelected"
                        wire:confirm="Are you sure you want to delete selected stock records?"
                        class="bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="hidden sm:inline">Delete Selected ({{ count($selectedStocks) }})</span>
                    </button>
                @endif

                <!-- Select All Button -->
                <button wire:click="selectAllStocks"
                    class="bg-gray-100 text-gray-700 hover:bg-gray-200 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="hidden sm:inline">Select All</span>
                </button>

                <button type="button"
                    class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <!-- PDF Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden sm:inline">Export PDF</span>
                </button>
                <button type="button"
                    class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <!-- Excel Icon -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden sm:inline">Export Excel</span>
                </button>
                <a wire:navigate href="{{ route('admin.stocks.create') }}"
                    class="bg-orange-500 text-white hover:bg-orange-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-orange-500">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 5v14M5 12h14" />
                    </svg>
                    <span class="hidden sm:inline">Add Stock</span>
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

        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stock Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Stock Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Items</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stocks->total() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Low Stock Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Low Stock</p>
                        <p class="text-2xl font-bold text-orange-600 mt-1">
                            {{ $stocks->where('quantity', '<=', \DB::raw('reorder_level'))->where('quantity', '>', 0)->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Expiring Soon Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Expiring Soon</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">
                            {{ $stocks->where('expiry_date', '<=', now()->addDays(30))->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Out of Stock Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Out of Stock</p>
                        <p class="text-2xl font-bold text-gray-600 mt-1">
                            {{ $stocks->where('quantity', '<=', 0)->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
            <!-- Filters Section -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <!-- Left Section: Search + Filters -->
                    <div class="flex flex-col md:flex-row gap-3 md:items-center flex-1">
                        <!-- Search -->
                        <div class="relative w-full max-w-xs">
                            <i
                                class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="search" wire:model.live="search"
                                class="w-full h-10 pl-10 pr-3 text-sm rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="Search stock..." />
                        </div>

                        <!-- Medicine Filter -->
                        <div class="relative">
                            <select wire:model.live="medicineFilter"
                                class="h-10 w-48 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Medicines</option>
                                @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <!-- Branch Filter -->
                        <div class="relative">
                            <select wire:model.live="branchFilter"
                                class="h-10 w-40 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Branches</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <!-- Stock Status Filter -->
                        <div class="relative">
                            <select wire:model.live="stockStatus"
                                class="h-10 w-40 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Status</option>
                                <option value="low">Low Stock</option>
                                <option value="expiring">Expiring Soon</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <!-- Items Per Page -->
                        <div class="relative">
                            <select wire:model.live="perPage"
                                class="h-10 w-24 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <!-- Clear Filters -->
                        <button wire:click="clearFilters"
                            class="h-10 px-4 text-sm text-gray-600 hover:text-orange-500 border border-gray-300 rounded-lg hover:border-orange-300 transition-colors">
                            Clear Filters
                        </button>
                    </div>

                    <!-- Right Section: Sort Buttons -->
                    <div class="flex gap-2 flex-wrap justify-end">
                        <button wire:click="sortBy('quantity')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Quantity
                        </button>
                        <button wire:click="sortBy('expiry_date')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Expiry Date
                        </button>
                        <button wire:click="sortBy('created_at')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Created At
                        </button>
                    </div>
                </div>
            </div>

            <!-- Desktop Table (md+) -->
            <div class="hidden md:block overflow-x-auto no-scrollbar scroll-hint">
                <table class="w-full">
                    <thead class="bg-gray-50 text-xs font-semibold text-left text-gray-500">
                        <tr class="text-sm font-semibold text-gray-600 tracking-wide uppercase">
                            <th scope="col" class="px-5 py-3 w-10">
                                <input type="checkbox" wire:model.live="selectAll"
                                    class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            </th>
                            <th scope="col" class="px-5 py-3">Medicine</th>
                            <th scope="col" class="px-5 py-3">Branch</th>
                            <th scope="col" class="px-5 py-3">Batch No</th>
                            <th scope="col" class="px-5 py-3">Expiry Date</th>
                            <th scope="col" class="px-5 py-3">Quantity</th>
                            <th scope="col" class="px-5 py-3">Price</th>
                            <th scope="col" class="px-5 py-3">Stock Status</th>
                            <th scope="col" class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($stocks as $stock)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <input type="checkbox" wire:model.live="selectedStocks"
                                        value="{{ $stock->id }}"
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $stock->medicine->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $stock->medicine->generic_name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    <span class="font-medium">{{ $stock->branch->name }}</span>
                                </td>
                                <td class="px-5 py-3">
                                    <span
                                        class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $stock->batch_number }}</span>
                                </td>
                                <td class="px-5 py-3 text-sm">
                                    @php
                                        $isExpiring = $stock->expiry_date <= now()->addDays(30);
                                        $isExpired = $stock->expiry_date <= now();
                                    @endphp
                                    <span
                                        class="{{ $isExpired ? 'text-red-600 font-semibold' : ($isExpiring ? 'text-orange-600' : 'text-gray-600') }}">
                                        {{ $stock->expiry_date->format('M d, Y') }}
                                        @if ($isExpired)
                                            <br><span class="text-xs text-red-500">Expired</span>
                                        @elseif($isExpiring)
                                            <br><span class="text-xs text-orange-500">Expiring Soon</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-sm font-semibold {{ $stock->quantity <= 0 ? 'text-red-600' : ($stock->quantity <= $stock->reorder_level ? 'text-orange-600' : 'text-gray-900') }}">
                                            {{ $stock->quantity }}
                                        </span>
                                        @if ($stock->quantity <= $stock->reorder_level && $stock->quantity > 0)
                                            <span class="text-xs text-orange-500">(Low)</span>
                                        @endif
                                        @if ($stock->quantity <= 0)
                                            <span class="text-xs text-red-500">(Out of Stock)</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Reorder: {{ $stock->reorder_level }}
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    <div>Buy: ৳{{ number_format($stock->purchase_price, 2) }}</div>
                                    <div>Sell: ৳{{ number_format($stock->selling_price, 2) }}</div>
                                </td>
                                <td class="px-5 py-3">
                                    @if ($stock->quantity <= 0)
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full bg-red-100 text-red-800 border border-red-200">
                                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                            Out of Stock
                                        </span>
                                    @elseif($stock->quantity <= $stock->reorder_level)
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full bg-orange-100 text-orange-800 border border-orange-200">
                                            <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                            Low Stock
                                        </span>
                                    @elseif($stock->expiry_date <= now()->addDays(30))
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                            Expiring Soon
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            In Stock
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a wire:navigate href="{{ route('admin.stocks.view', $stock->id) }}"
                                            class="p-2 rounded bg-orange-50 text-orange-600 hover:bg-orange-100 transition-colors"
                                            title="View Stock">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a wire:navigate href="{{ route('admin.stocks.edit', $stock->id) }}"
                                            class="p-2 rounded bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                            title="Edit Stock">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <button wire:click="deleteStock({{ $stock->id }})"
                                            wire:confirm="Are you sure you want to delete this stock record?"
                                            class="p-2 rounded bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            title="Delete Stock">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900 mb-2">No stock records found</p>
                                        <p class="text-sm text-gray-600 mb-4">Get started by adding your first stock
                                            record.</p>
                                        <a wire:navigate href="{{ route('admin.stocks.create') }}"
                                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition-colors">
                                            Add Stock
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards (visible < md) -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($stocks as $stock)
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <input type="checkbox" wire:model.live="selectedStocks"
                                        value="{{ $stock->id }}"
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $stock->medicine->name }}
                                        </h3>
                                        <p class="text-xs text-gray-500">{{ $stock->branch->name }} •
                                            {{ $stock->batch_number }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                    <div>
                                        <span class="font-medium">Quantity:</span>
                                        <span
                                            class="{{ $stock->quantity <= 0 ? 'text-red-600' : ($stock->quantity <= $stock->reorder_level ? 'text-orange-600' : 'text-gray-900') }}">
                                            {{ $stock->quantity }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Expiry:</span>
                                        <span
                                            class="{{ $stock->expiry_date <= now()->addDays(30) ? 'text-orange-600' : 'text-gray-600' }}">
                                            {{ $stock->expiry_date->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Buy Price:</span>
                                        <span>৳{{ number_format($stock->purchase_price, 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Sell Price:</span>
                                        <span>৳{{ number_format($stock->selling_price, 2) }}</span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    @if ($stock->quantity <= 0)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Out of Stock
                                        </span>
                                    @elseif($stock->quantity <= $stock->reorder_level)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800 border border-orange-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                            Low Stock
                                        </span>
                                    @elseif($stock->expiry_date <= now()->addDays(30))
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                            Expiring Soon
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            In Stock
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-start gap-1">
                                <a wire:navigate href="{{ route('admin.stocks.edit', $stock->id) }}"
                                    class="bg-white text-gray-500 hover:text-blue-500 p-2 rounded border border-gray-300 transition-colors"
                                    aria-label="Edit {{ $stock->medicine->name }}">
                                    <i class="far fa-edit text-sm" aria-hidden="true"></i>
                                </a>
                                <button wire:click="deleteStock({{ $stock->id }})"
                                    wire:confirm="Are you sure you want to delete this stock record?"
                                    class="bg-white text-gray-500 hover:text-red-500 p-2 rounded border border-gray-300 transition-colors"
                                    aria-label="Delete {{ $stock->medicine->name }}">
                                    <i class="far fa-trash-alt text-sm" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <p class="text-lg font-medium text-gray-900 mb-2">No stock records found</p>
                        <p class="text-sm text-gray-600 mb-4">Get started by adding your first stock record.</p>
                        <a wire:navigate href="{{ route('admin.stocks.create') }}"
                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition-colors">
                            Add Stock
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <x-common.pagination :paginator="$stocks" :pageRange="$pageRange" />
        </div>
    </div>
</main>
