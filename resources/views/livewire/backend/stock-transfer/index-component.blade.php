<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Stock Transfers
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Manage stock transfers between branches
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                @if (!empty($selectedTransfers) && count($selectedTransfers) > 0)
                    <button wire:click="deleteSelected"
                        wire:confirm="Are you sure you want to delete selected transfer records?"
                        class="bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="hidden sm:inline">Delete Selected ({{ count($selectedTransfers) }})</span>
                    </button>
                @endif

                <!-- Select All Button -->
                <button wire:click="selectAllTransfers"
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
                <a wire:navigate href="{{ route('admin.stock-transfers.create') }}"
                    class="bg-orange-500 text-white hover:bg-orange-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-orange-500">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 5v14M5 12h14" />
                    </svg>
                    <span class="hidden sm:inline">New Transfer</span>
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

        <!-- Transfer Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Transfers Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Transfers</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalItems }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-orange-600 mt-1">{{ $pendingTransfers }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- In Progress Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">In Progress</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $inProgressTransfers }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $completedTransfers }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
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
                                placeholder="Search transfers..." />
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

                        <!-- Status Filter -->
                        <div class="relative">
                            <select wire:model.live="statusFilter"
                                class="h-10 w-40 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
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
                        <button wire:click="sortBy('transfer_date')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Transfer Date
                        </button>
                        <button wire:click="sortBy('status')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Status
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
                            <th scope="col" class="px-5 py-3">Transfer #</th>
                            <th scope="col" class="px-5 py-3">From Branch</th>
                            <th scope="col" class="px-5 py-3">To Branch</th>
                            <th scope="col" class="px-5 py-3">Transfer Date</th>
                            <th scope="col" class="px-5 py-3">Items</th>
                            <th scope="col" class="px-5 py-3">Status</th>
                            <th scope="col" class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($transfers as $transfer)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <input type="checkbox" wire:model.live="selectedTransfers"
                                        value="{{ $transfer->id }}"
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                </td>
                                <td class="px-5 py-3">
                                    <div class="font-medium text-gray-900">{{ $transfer->transfer_number }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $transfer->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    <span class="font-medium">{{ $transfer->fromBranch->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    <span class="font-medium">{{ $transfer->toBranch->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    {{ $transfer->transfer_date->format('M d, Y') }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="font-semibold text-gray-900">
                                        {{ $transfer->transferItems->count() }}
                                    </span>
                                    <div class="text-xs text-gray-500 mt-1">
                                        @foreach ($transfer->transferItems->take(2) as $item)
                                            {{ $item->medicine->name ?? 'N/A' }} ({{ $item->quantity }})<br>
                                        @endforeach
                                        @if ($transfer->transferItems->count() > 2)
                                            +{{ $transfer->transferItems->count() - 2 }} more
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    @if ($transfer->status === 'pending')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                            Pending
                                        </span>
                                    @elseif($transfer->status === 'in_progress')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                            In Progress
                                        </span>
                                    @elseif($transfer->status === 'completed')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            Completed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a wire:navigate
                                            href="{{ route('admin.stock-transfers.view', $transfer->id) }}"
                                            class="p-2 rounded bg-orange-50 text-orange-600 hover:bg-orange-100 transition-colors"
                                            title="View Transfer">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a wire:navigate
                                            href="{{ route('admin.stock-transfers.edit', $transfer->id) }}"
                                            class="p-2 rounded bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                            title="Edit Transfer">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <button wire:click="deleteTransfer({{ $transfer->id }})"
                                            wire:confirm="Are you sure you want to delete this transfer record?"
                                            class="p-2 rounded bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            title="Delete Transfer">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900 mb-2">No transfer records found</p>
                                        <p class="text-sm text-gray-600 mb-4">Get started by creating your first stock
                                            transfer.</p>
                                        <a wire:navigate href="{{ route('admin.stock-transfers.create') }}"
                                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition-colors">
                                            Create Transfer
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
                @forelse($transfers as $transfer)
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <input type="checkbox" wire:model.live="selectedTransfers"
                                        value="{{ $transfer->id }}"
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">
                                            {{ $transfer->transfer_number }}</h3>
                                        <p class="text-xs text-gray-500">
                                            {{ $transfer->transfer_date->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                    <div>
                                        <span class="font-medium">From:</span>
                                        <span>{{ $transfer->fromBranch->name ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">To:</span>
                                        <span>{{ $transfer->toBranch->name ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Items:</span>
                                        <span>{{ $transfer->transferItems->count() }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Status:</span>
                                        <span>
                                            @if ($transfer->status === 'pending')
                                                <span class="text-yellow-600">Pending</span>
                                            @elseif($transfer->status === 'in_progress')
                                                <span class="text-blue-600">In Progress</span>
                                            @elseif($transfer->status === 'completed')
                                                <span class="text-green-600">Completed</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-1">
                                <a wire:navigate href="{{ route('admin.stock-transfers.view', $transfer->id) }}"
                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300 transition-colors"
                                    aria-label="View {{ $transfer->transfer_number }}">
                                    <i class="far fa-eye text-sm" aria-hidden="true"></i>
                                </a>
                                <a wire:navigate href="{{ route('admin.stock-transfers.edit', $transfer->id) }}"
                                    class="bg-white text-gray-500 hover:text-blue-500 p-2 rounded border border-gray-300 transition-colors"
                                    aria-label="Edit {{ $transfer->transfer_number }}">
                                    <i class="far fa-edit text-sm" aria-hidden="true"></i>
                                </a>
                                <button wire:click="deleteTransfer({{ $transfer->id }})"
                                    wire:confirm="Are you sure you want to delete this transfer record?"
                                    class="bg-white text-gray-500 hover:text-red-500 p-2 rounded border border-gray-300 transition-colors"
                                    aria-label="Delete {{ $transfer->transfer_number }}">
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
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <p class="text-lg font-medium text-gray-900 mb-2">No transfer records found</p>
                        <p class="text-sm text-gray-600 mb-4">Get started by creating your first stock transfer.</p>
                        <a wire:navigate href="{{ route('admin.stock-transfers.create') }}"
                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition-colors">
                            Create Transfer
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <x-common.pagination :paginator="$transfers" :pageRange="$pageRange" />
        </div>
    </div>
</main>
