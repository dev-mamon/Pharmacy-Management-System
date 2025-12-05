<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Purchase Management
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Manage and track your pharmacy purchases
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                @if (count($selectedPurchases) > 0)
                    <button wire:click="deleteSelected" wire:confirm="Are you sure you want to delete selected purchases?"
                        class="bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="hidden sm:inline">Delete Selected ({{ count($selectedPurchases) }})</span>
                    </button>
                @endif

                <!-- Select All Button -->
                <button wire:click="selectAllPurchases"
                    class="bg-gray-100 text-gray-700 hover:bg-gray-200 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="hidden sm:inline">Select All</span>
                </button>

                <button type="button"
                    class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden sm:inline">Export PDF</span>
                </button>
                <button type="button"
                    class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden sm:inline">Export Excel</span>
                </button>
                <a wire:navigate href="{{ route('admin.purchases.create') }}"
                    class="bg-orange-500 text-white hover:bg-orange-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-orange-500">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 5v14M5 12h14" />
                    </svg>
                    <span class="hidden sm:inline">New Purchase</span>
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

        <!-- Purchase Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Purchases Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Purchases</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $purchases->total() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Purchases Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-orange-600 mt-1">
                            {{ $purchases->where('status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Purchases Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">
                            {{ $purchases->where('status', 'completed')->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Amount Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Amount</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1">
                            ৳{{ number_format($purchases->sum('grand_total'), 2) }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                placeholder="Search purchases..." />
                        </div>

                        <!-- Supplier Filter -->
                        <div class="relative">
                            <select wire:model.live="supplierFilter"
                                class="h-10 w-48 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Suppliers</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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

                        <!-- Status Filter -->
                        <div class="relative">
                            <select wire:model.live="statusFilter"
                                class="h-10 w-32 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="flex gap-2">
                            <input type="date" wire:model.live="dateFrom"
                                class="h-10 px-3 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="From Date">
                            <input type="date" wire:model.live="dateTo"
                                class="h-10 px-3 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="To Date">
                        </div>

                        <!-- Items Per Page -->
                        <div class="relative">
                            <select wire:model.live="perPage"
                                class="h-10 w-24 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="7">7</option>
                                <option value="14">14</option>
                                <option value="28">28</option>
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
                </div>
            </div>

            <!-- Desktop Grid Layout -->
            <div class="hidden md:block overflow-x-auto no-scrollbar">
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-7 gap-4 p-4">
                    @forelse($purchases as $purchase)
                        <div
                            class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <!-- Card Header -->
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <input type="checkbox" wire:model.live="selectedPurchases"
                                                value="{{ $purchase->id }}"
                                                class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                            <h3 class="font-bold text-gray-900 text-sm">
                                                {{ $purchase->purchase_number }}</h3>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                                                {{ $purchase->status === 'completed'
                                                    ? 'bg-green-100 text-green-800'
                                                    : ($purchase->status === 'pending'
                                                        ? 'bg-orange-100 text-orange-800'
                                                        : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($purchase->status) }}
                                            </span>
                                            <span
                                                class="text-xs text-gray-600">{{ $purchase->purchase_date->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-4">
                                <!-- Supplier & Branch Info -->
                                <div class="space-y-3 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Supplier</p>
                                        <p class="font-medium text-gray-900 text-sm">{{ $purchase->supplier->name }}
                                        </p>
                                        <p class="text-xs text-gray-600">{{ $purchase->supplier->phone }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Branch</p>
                                        <p class="font-medium text-gray-900 text-sm">{{ $purchase->branch->name }}</p>
                                    </div>
                                </div>

                                <!-- Amount Info -->
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Grand Total</p>
                                            <p class="text-lg font-bold text-gray-900">
                                                ৳{{ number_format($purchase->grand_total, 2) }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-green-600 font-medium">
                                                -৳{{ number_format($purchase->discount, 2) }} disc
                                            </p>
                                            <p class="text-xs text-gray-500">Tax:
                                                ৳{{ number_format($purchase->tax_amount, 2) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Items Count -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $purchase->purchaseItems->count() }} items
                                    </span>
                                    <span class="text-sm text-gray-600">
                                        By {{ $purchase->user->name ?? 'N/A' }}
                                    </span>
                                </div>

                                <!-- Status Actions -->
                                @if ($purchase->status === 'pending')
                                    <div class="flex gap-2 mb-3">
                                        <button wire:click="updateStatus({{ $purchase->id }}, 'completed')"
                                            class="flex-1 bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-xs font-medium transition-colors">
                                            Complete
                                        </button>
                                        <button wire:click="updateStatus({{ $purchase->id }}, 'cancelled')"
                                            class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-xs font-medium transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a wire:navigate href="{{ route('admin.purchases.view', $purchase->id) }}"
                                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded text-xs font-medium transition-colors">
                                        View
                                    </a>
                                    <a wire:navigate href="{{ route('admin.purchases.edit', $purchase->id) }}"
                                        class="flex-1 text-center bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded text-xs font-medium transition-colors">
                                        Edit
                                    </a>
                                    <button wire:click="deletePurchase({{ $purchase->id }})"
                                        wire:confirm="Are you sure you want to delete this purchase?"
                                        class="flex-1 text-center bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded text-xs font-medium transition-colors">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
                                <div class="max-w-md mx-auto">
                                    <div
                                        class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">No Purchases Found</h3>
                                    <p class="text-gray-600 mb-6">You haven't created any purchase orders yet. Start by
                                        creating your first purchase.</p>
                                    <a wire:navigate href="{{ route('admin.purchases.create') }}"
                                        class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Create New Purchase
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Mobile List Layout -->
            <div class="md:hidden space-y-3 p-4">
                @forelse($purchases as $purchase)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <input type="checkbox" wire:model.live="selectedPurchases"
                                        value="{{ $purchase->id }}"
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    <h3 class="font-bold text-gray-900 text-sm">{{ $purchase->purchase_number }}</h3>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                                        {{ $purchase->status === 'completed'
                                            ? 'bg-green-100 text-green-800'
                                            : ($purchase->status === 'pending'
                                                ? 'bg-orange-100 text-orange-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($purchase->status) }}
                                    </span>
                                    <span
                                        class="text-xs text-gray-600">{{ $purchase->purchase_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">
                                    ৳{{ number_format($purchase->grand_total, 2) }}</p>
                                <p class="text-xs text-green-600">-৳{{ number_format($purchase->discount, 2) }} disc
                                </p>
                            </div>
                        </div>

                        <!-- Info Row -->
                        <div class="grid grid-cols-2 gap-2 mb-3 text-sm">
                            <div>
                                <p class="text-gray-500 text-xs">Supplier</p>
                                <p class="font-medium">{{ $purchase->supplier->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Branch</p>
                                <p class="font-medium">{{ $purchase->branch->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Items</p>
                                <p class="font-medium">{{ $purchase->purchaseItems->count() }} items</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">By</p>
                                <p class="font-medium">{{ $purchase->user->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-3 border-t border-gray-100">
                            @if ($purchase->status === 'pending')
                                <button wire:click="updateStatus({{ $purchase->id }}, 'completed')"
                                    class="flex-1 bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-xs font-medium">
                                    Complete
                                </button>
                                <button wire:click="updateStatus({{ $purchase->id }}, 'cancelled')"
                                    class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-xs font-medium">
                                    Cancel
                                </button>
                            @endif
                        </div>

                        <div class="flex gap-2 pt-3">
                            <a wire:navigate href="{{ route('admin.purchases.view', $purchase->id) }}"
                                class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded text-sm font-medium">
                                View
                            </a>
                            <a wire:navigate href="{{ route('admin.purchases.edit', $purchase->id) }}"
                                class="flex-1 text-center bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded text-sm font-medium">
                                Edit
                            </a>
                            <button wire:click="deletePurchase({{ $purchase->id }})"
                                wire:confirm="Are you sure you want to delete this purchase?"
                                class="flex-1 text-center bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded text-sm font-medium">
                                Delete
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8 text-center">
                        <div
                            class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No Purchases</h3>
                        <p class="text-gray-600 mb-4 text-sm">Start by creating your first purchase order.</p>
                        <a wire:navigate href="{{ route('admin.purchases.create') }}"
                            class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Create Purchase
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Bulk Actions -->
            @if ($selectedPurchases && count($selectedPurchases) > 0)
                <div class="fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50">
                    <div
                        class="bg-white rounded-xl shadow-lg border border-gray-200 px-6 py-3 flex items-center gap-4">
                        <span class="text-sm font-medium text-gray-700">
                            {{ count($selectedPurchases) }} selected
                        </span>
                        <div class="flex items-center gap-2">
                            <button wire:click="bulkComplete"
                                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium">
                                Complete Selected
                            </button>
                            <button wire:click="bulkDelete"
                                wire:confirm="Are you sure you want to delete all selected purchases?"
                                class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium">
                                Delete Selected
                            </button>
                            <button wire:click="$set('selectedPurchases', [])"
                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Pagination -->
            @if ($purchases->hasPages())
                <div class="p-4  border-gray-100">
                    <x-common.pagination :paginator="$purchases" :pageRange="$pageRange" />
                </div>
            @endif
        </div>
    </div>
</main>
