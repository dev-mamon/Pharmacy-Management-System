<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Branch Management
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Manage and organize your pharmacy branches
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
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
                <a wire:navigate href="{{ route('admin.branches.create') }}"
                    class="bg-orange-500 text-white hover:bg-orange-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-orange-500">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 5v14M5 12h14" />
                    </svg>
                    <span class="hidden sm:inline">Add Branch</span>
                </a>
            </div>
        </div>

        <!-- Flash Message -->
        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
            <!-- Filters Section -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <!-- Left Section: Search + Per Page -->
                    <div class="flex flex-col md:flex-row gap-3 md:items-center flex-1">
                        <!-- Search -->
                        <div class="relative w-full max-w-xs">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="search" wire:model.live="search"
                                class="w-full h-10 pl-10 pr-3 text-sm rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="Search branches..." />
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
                        <button wire:click="sortBy('name')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Name
                        </button>
                        <button wire:click="sortBy('is_active')"
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
                            <th scope="col" class="px-5 py-3">Code</th>
                            <th scope="col" class="px-5 py-3">Branch Name</th>
                            <th scope="col" class="px-5 py-3">Phone</th>
                            <th scope="col" class="px-5 py-3">Email</th>
                            <th scope="col" class="px-5 py-3">Opening Hours</th>
                            <th scope="col" class="px-5 py-3">Status</th>
                            <th scope="col" class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($branches as $branch)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 text-sm">
                                    <span
                                        class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $branch->code }}</span>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-900">
                                    <div class="font-medium">{{ $branch->name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($branch->address, 30) }}</div>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">{{ $branch->phone }}</td>
                                <td class="px-5 py-3 text-sm text-gray-600">{{ $branch->email ?? 'N/A' }}</td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($branch->opening_time)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($branch->closing_time)->format('h:i A') }}
                                </td>
                                <td class="px-5 py-3">
                                    @if ($branch->is_active)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-red-50 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a wire:navigate href="{{ route('admin.branches.view', $branch->id) }}"
                                            class="p-2 rounded bg-orange-50 text-orange-600 hover:bg-orange-100">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a wire:navigate href="{{ route('admin.branches.edit', $branch->id) }}"
                                            class="p-2 rounded bg-blue-50 text-blue-600 hover:bg-blue-100">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <button wire:click="deleteBranch({{ $branch->id }})"
                                            wire:confirm="Are you sure you want to delete this branch?"
                                            class="p-2 rounded bg-red-50 text-red-600 hover:bg-red-100">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-8V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v1M9 7h6" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900">No branches found</p>
                                        <p class="text-sm text-gray-600 mt-1">Get started by creating your first
                                            branch.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards (visible < md) -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($branches as $branch)
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $branch->code }}</span>
                                    <h3 class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $branch->name }}
                                    </h3>
                                </div>
                                <div class="mt-2 text-xs text-gray-600 space-y-1">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-phone text-gray-400"></i>
                                        <span>{{ $branch->phone }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                        <span>{{ $branch->email ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-clock text-gray-400"></i>
                                        <span>{{ \Carbon\Carbon::parse($branch->opening_time)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($branch->closing_time)->format('h:i A') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs font-[14px]">Status:</span>
                                        @if ($branch->is_active)
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded bg-red-50 text-red-700 border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-2">
                                <a wire:navigate href="{{ route('admin.branches.view', $branch->id) }}"
                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                    aria-label="View {{ $branch->name }}">
                                    <i class="far fa-eye" aria-hidden="true"></i>
                                </a>
                                <a wire:navigate href="{{ route('admin.branches.edit', $branch->id) }}"
                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                    aria-label="Edit {{ $branch->name }}">
                                    <i class="far fa-edit" aria-hidden="true"></i>
                                </a>
                                <button wire:click="deleteBranch({{ $branch->id }})"
                                    wire:confirm="Are you sure you want to delete this branch?"
                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                    aria-label="Delete {{ $branch->name }}">
                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-8V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v1M9 7h6" />
                        </svg>
                        <p class="text-lg font-medium text-gray-900">No branches found</p>
                        <p class="text-sm text-gray-600 mt-1">Get started by creating your first branch.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <x-common.pagination :paginator="$branches" :pageRange="$pageRange" />
        </div>
    </div>
</main>
