<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Loyalty Programs
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Manage and organize your loyalty programs
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <button type="button"
                    class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <!-- Inline PDF SVG -->
                    <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="" />
                    <span class="hidden sm:inline">Export PDF</span>
                </button>
                <button type="button"
                    class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <!-- Inline Excel SVG -->
                    <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="" />
                    <span class="hidden sm:inline">Export Excel</span>
                </button>
                <button type="button"
                    class="bg-orange-500 text-white hover:bg-orange-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-orange-500">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 5v14M5 12h14" />
                    </svg>
                    <span class="hidden sm:inline">Add Program</span>
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('message') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                    <!-- Left Section: Search + Per Page + Status Filter -->
                    <div class="flex flex-col md:flex-row gap-3 md:items-center flex-1">
                        <!-- Search -->
                        <div class="relative w-full max-w-xs">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="search" wire:model.live="search"
                                class="w-full h-10 pl-10 pr-3 text-sm rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="Search programs..." />
                        </div>

                        <!-- Status Filter -->
                        <div class="relative">
                            <select wire:model.live="statusFilter"
                                class="h-10 w-32 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="expired">Expired</option>
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
                                <option>5</option>
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section: Sort Buttons -->
                    <div class="flex gap-2 flex-wrap justify-end">
                        <button wire:click="sortBy('name')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Name
                            @if ($sortField === 'name')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs"></i>
                            @else
                                <i class="fas fa-sort text-xs text-gray-300"></i>
                            @endif
                        </button>
                        <button wire:click="sortBy('is_active')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Status
                            @if ($sortField === 'is_active')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs"></i>
                            @else
                                <i class="fas fa-sort text-xs text-gray-300"></i>
                            @endif
                        </button>
                        <button wire:click="sortBy('created_at')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Created At
                            @if ($sortField === 'created_at')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs"></i>
                            @else
                                <i class="fas fa-sort text-xs text-gray-300"></i>
                            @endif
                        </button>
                    </div>

                </div>
            </div>

            <!-- Desktop Table (md+) -->
            <div class="hidden md:block overflow-x-auto no-scrollbar scroll-hint">
                <table class="w-full">
                    <thead class="bg-gray-50 text-xs font-semibold text-left text-gray-500">
                        <tr class="text-sm font-semibold text-gray-600 tracking-wide uppercase">
                            <th scope="col" class="px-5 py-3 cursor-pointer" wire:click="sortBy('name')">
                                <div class="flex items-center gap-1">
                                    <span>Name</span>
                                    @if ($sortField === 'name')
                                        <i
                                            class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs"></i>
                                    @else
                                        <i class="fas fa-sort text-xs text-gray-300"></i>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-5 py-3">Points per Purchase</th>
                            <th scope="col" class="px-5 py-3">Points per Amount</th>
                            <th scope="col" class="px-5 py-3">Min. Redemption</th>
                            <th scope="col" class="px-5 py-3">Point Value</th>
                            <th scope="col" class="px-5 py-3">Valid From</th>
                            <th scope="col" class="px-5 py-3">Valid To</th>
                            <th scope="col" class="px-5 py-3 cursor-pointer" wire:click="sortBy('is_active')">
                                <div class="flex items-center gap-1">
                                    <span>Status</span>
                                    @if ($sortField === 'is_active')
                                        <i
                                            class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} text-xs"></i>
                                    @else
                                        <i class="fas fa-sort text-xs text-gray-300"></i>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($programs as $program)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-sm text-gray-900">
                                    {{ $program->name }}
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    {{ $program->points_per_purchase }}
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    {{ $program->points_per_amount }}
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    {{ $program->minimum_redemption_points }}
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    ${{ $program->point_value }}
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    {{ $program->valid_from ? $program->valid_from->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    {{ $program->valid_to ? $program->valid_to->format('M d, Y') : 'No expiry' }}
                                </td>
                                <td class="px-5 py-3">
                                    @php
                                        $isExpired = $program->valid_to && $program->valid_to->isPast();
                                        $isActive = $program->is_active && !$isExpired;
                                    @endphp

                                    @if ($isExpired)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-red-50 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Expired
                                        </span>
                                    @elseif($isActive)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-gray-50 text-gray-700 border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="p-2 rounded bg-orange-50 text-orange-600 hover:bg-orange-100">
                                            <i class="far fa-eye"></i>
                                        </button>
                                        <button class="p-2 rounded bg-blue-50 text-blue-600 hover:bg-blue-100">
                                            <i class="far fa-edit"></i>
                                        </button>

                                        <button wire:click="deleteProgram({{ $program->id }})"
                                            wire:confirm="Are you sure you want to delete this loyalty program?"
                                            class="p-2 rounded bg-red-50 text-red-600 hover:bg-red-100">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-gift text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-lg font-medium text-gray-900">No loyalty programs found</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            @if ($search || $statusFilter)
                                                Try adjusting your search or filter to find what you're looking for.
                                            @else
                                                Get started by creating your first loyalty program.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards (visible < md) -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($programs as $program)
                    @php
                        $isExpired = $program->valid_to && $program->valid_to->isPast();
                        $isActive = $program->is_active && !$isExpired;
                    @endphp

                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $program->name }}
                                    </h3>
                                    @if ($isExpired)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded bg-red-50 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Expired
                                        </span>
                                    @elseif($isActive)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded bg-green-50 text-green-700 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded bg-gray-50 text-gray-700 border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-2 text-xs text-gray-600 grid grid-cols-2 gap-2">
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-[14px]">Points/Purchase:</span>
                                        <span>{{ $program->points_per_purchase }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-[14px]">Points/Amount:</span>
                                        <span>{{ $program->points_per_amount }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-[14px]">Min. Redemption:</span>
                                        <span>{{ $program->minimum_redemption_points }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-[14px]">Point Value:</span>
                                        <span>${{ $program->point_value }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-[14px]">From:</span>
                                        <span>{{ $program->valid_from ? $program->valid_from->format('M d, Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-[14px]">To:</span>
                                        <span>{{ $program->valid_to ? $program->valid_to->format('M d, Y') : 'No expiry' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-1">
                                <button
                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                    aria-label="View {{ $program->name }}">
                                    <i class="far fa-eye" aria-hidden="true"></i>
                                </button>
                                <button
                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                    aria-label="Edit {{ $program->name }}">
                                    <i class="far fa-edit" aria-hidden="true"></i>
                                </button>
                                <button wire:click="deleteProgram({{ $program->id }})"
                                    wire:confirm="Are you sure you want to delete this loyalty program?"
                                    class="bg-white text-red-500 hover:text-red-600 p-2 rounded border border-gray-300"
                                    aria-label="Delete {{ $program->name }}">
                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-gift text-3xl text-gray-300 mb-3"></i>
                        <p class="text-base font-medium text-gray-900">No loyalty programs found</p>
                        <p class="text-sm text-gray-600 mt-1">
                            @if ($search || $statusFilter)
                                Try adjusting your search or filter
                            @else
                                Create your first loyalty program
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <x-common.pagination :paginator="$programs" :pageRange="$pageRange" />
        </div>
    </div>
</main>
