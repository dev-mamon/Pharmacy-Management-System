<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50" aria-hidden="true"></div>

        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">
                                    {{ $isBulkDelete ? 'Delete Selected Returns' : 'Delete Return' }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        @if ($isBulkDelete)
                                            Are you sure you want to delete {{ count($selectedReturns) }} selected
                                            return(s)? This action cannot be undone.
                                        @else
                                            @php
                                                $return = $returns->firstWhere('id', $returnToDelete);
                                            @endphp
                                            Are you sure you want to delete
                                            @if ($return)
                                                <span class="font-semibold">Return #{{ $return->return_number }}</span>?
                                            @else
                                                this return
                                            @endif
                                            This action cannot be undone.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button wire:click="performDelete" type="button"
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Delete
                        </button>
                        <button wire:click="closeDeleteModal" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Sales Returns Management
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Manage and track sales returns
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                @if (count($selectedReturns) > 0)
                    <button wire:click="confirmBulkDelete"
                        class="bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="hidden sm:inline">Delete Selected ({{ count($selectedReturns) }})</span>
                    </button>
                @endif

                <!-- Select All Button -->
                <button wire:click="selectAllReturns"
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
                <a wire:navigate href="{{ route('admin.returns.create') }}"
                    class="bg-orange-500 text-white hover:bg-orange-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-orange-500">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 5v14M5 12h14" />
                    </svg>
                    <span class="hidden sm:inline">Create Return</span>
                </a>
            </div>
        </div>

        <!-- Returns Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Returns Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Returns</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_returns'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.801 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.801 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Today's Returns Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Today's Returns</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['today_returns'] }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                            ৳{{ number_format($stats['total_amount'], 2) }}</p>
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

            <!-- Pending Returns Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Returns</p>
                        <p class="text-2xl font-bold text-orange-600 mt-1">
                            {{ $stats['pending_count'] }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
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
                                placeholder="Search by return number, invoice..." />
                        </div>

                        <!-- Date Range Filter -->
                        <div class="flex gap-2">
                            <input type="date" wire:model.live="startDate"
                                class="h-10 px-3 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            <input type="date" wire:model.live="endDate"
                                class="h-10 px-3 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" />
                        </div>

                        <!-- Status Filter -->
                        <div class="relative">
                            <select wire:model.live="statusFilter"
                                class="h-10 w-32 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
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
                    </div>

                    <!-- Right Section: Sort Buttons -->
                    <div class="flex gap-2 flex-wrap justify-end">
                        <button wire:click="sortBy('return_date')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Date
                        </button>
                        <button wire:click="sortBy('total_amount')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Amount
                        </button>
                        <button wire:click="sortBy('status')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Status
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
                            <th scope="col" class="px-5 py-3">Return No.</th>
                            <th scope="col" class="px-5 py-3">Invoice No.</th>
                            <th scope="col" class="px-5 py-3">Customer</th>
                            <th scope="col" class="px-5 py-3">Date</th>
                            <th scope="col" class="px-5 py-3">Items</th>
                            <th scope="col" class="px-5 py-3">Amount</th>
                            <th scope="col" class="px-5 py-3">Status</th>
                            <th scope="col" class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($returns as $return)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3">
                                    <input type="checkbox" wire:model.live="selectedReturns"
                                        value="{{ $return->id }}"
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $return->return_number }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $return->branch->name ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="text-sm text-gray-900">
                                        {{ $return->sale->invoice_number ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="text-sm text-gray-900">
                                        {{ $return->customer->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $return->customer->phone ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    {{ $return->return_date->format('d M, Y') }}
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    <span class="px-2 py-1 bg-gray-100 rounded-full">
                                        {{ $return->items->count() }} items
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="text-sm font-semibold text-gray-900">
                                        ৳{{ number_format($return->total_amount, 2) }}
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full {{ $return->status_badge }}">
                                        <span
                                            class="w-2 h-2 rounded-full
                                            {{ $return->status === 'completed'
                                                ? 'bg-green-500'
                                                : ($return->status === 'pending'
                                                    ? 'bg-yellow-500'
                                                    : ($return->status === 'approved'
                                                        ? 'bg-blue-500'
                                                        : 'bg-red-500')) }}"></span>
                                        {{ ucfirst($return->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a wire:navigate href="{{ route('admin.returns.view', $return->id) }}"
                                            class="p-2 rounded bg-green-50 text-green-600 hover:bg-green-100 transition-colors"
                                            title="View Return">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        @if ($return->status === 'pending')
                                            <a wire:navigate href="{{ route('admin.returns.edit', $return->id) }}"
                                                class="p-2 rounded bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                                title="Edit Return">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        @endif
                                        <button wire:click="confirmDelete({{ $return->id }})"
                                            class="p-2 rounded bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            title="Delete Return">
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
                                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900 mb-2">No returns found</p>
                                        <p class="text-sm text-gray-600 mb-4">Get started by creating your first
                                            return.
                                        </p>
                                        <a wire:navigate href="{{ route('admin.returns.create') }}"
                                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition-colors">
                                            Create Return
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
                @forelse($returns as $return)
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <input type="checkbox" wire:model.live="selectedReturns"
                                        value="{{ $return->id }}"
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $return->return_number }}
                                        </h3>
                                        <p class="text-xs text-gray-500">{{ $return->return_date->format('d M, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-2 text-xs text-gray-600">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-medium">Invoice:</span>
                                            {{ $return->sale->invoice_number ?? 'N/A' }}
                                        </div>
                                        <span class="px-2 py-1 bg-gray-100 rounded-full">
                                            {{ $return->items->count() }} items
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Customer:</span>
                                        {{ $return->customer->name ?? 'N/A' }}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium">Amount:</span>
                                        ৳{{ number_format($return->total_amount, 2) }}
                                        <span class="px-2 py-1 rounded-full text-xs {{ $return->status_badge }}">
                                            {{ ucfirst($return->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-1">
                                <a wire:navigate href="{{ route('admin.returns.view', $return->id) }}"
                                    class="bg-white text-gray-500 hover:text-green-500 p-2 rounded border border-gray-300 transition-colors"
                                    aria-label="View {{ $return->return_number }}">
                                    <i class="far fa-eye text-sm" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                        <p class="text-lg font-medium text-gray-900 mb-2">No returns found</p>
                        <p class="text-sm text-gray-600 mb-4">Get started by creating your first return.</p>
                        <a wire:navigate href="{{ route('admin.returns.create') }}"
                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition-colors">
                            Create Return
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <x-common.pagination :paginator="$paginator" :pageRange="$pageRange" />
        </div>
    </div>
</main>
