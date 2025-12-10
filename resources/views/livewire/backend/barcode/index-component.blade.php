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
                                    {{ $isBulkDelete ? 'Delete Selected Barcodes' : 'Delete Barcode' }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        @if ($isBulkDelete)
                                            Are you sure you want to delete {{ count($selectedItems) }} selected
                                            barcode(s)? This action cannot be undone.
                                        @else
                                            @php
                                                $barcode = $barcodes->firstWhere('id', $barcodeToDelete);
                                            @endphp
                                            Are you sure you want to delete
                                            @if ($barcode)
                                                <span class="font-semibold">{{ $barcode->barcode }}</span> barcode?
                                            @else
                                                this barcode
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
                    Barcode Management
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Generate and manage medicine barcodes
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                @if (count($selectedItems) > 0)
                    <button wire:click="confirmBulkDelete"
                        class="bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="hidden sm:inline">Delete Selected ({{ count($selectedItems) }})</span>
                    </button>
                @endif

                <!-- Select All Button -->
                <button wire:click="selectAllBarcodes"
                    class="bg-gray-100 text-gray-700 hover:bg-gray-200 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="hidden sm:inline">Select All</span>
                </button>

                <a wire:navigate href="{{ route('admin.medicine.barcode.create') }}"
                    class="bg-orange-500 text-white hover:bg-orange-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-orange-500">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 5v14M5 12h14" />
                    </svg>
                    <span class="hidden sm:inline">Generate Barcode</span>
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

        <!-- Table Card -->
        <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
            <!-- Filters Section -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <!-- Left Section: Search + Filters -->
                    <div class="flex flex-col md:flex-row gap-3 md:items-center flex-1">
                        <!-- Search -->
                        <div class="relative w-full max-w-xs">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="search" wire:model.live="search"
                                class="w-full h-10 pl-10 pr-3 text-sm rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="Search barcode or medicine..." />
                        </div>

                        <!-- Medicine Filter -->
                        <div class="relative">
                            <select wire:model.live="medicineFilter"
                                class="h-10 w-40 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
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

                        <!-- Barcode Type Filter -->
                        <div class="relative">
                            <select wire:model.live="barcodeTypeFilter"
                                class="h-10 w-40 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Types</option>
                                @foreach ($barcodeTypes as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
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
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
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
                        <button wire:click="sortBy('barcode')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Barcode
                        </button>
                        <button wire:click="sortBy('created_at')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Created Date
                        </button>
                        <button wire:click="sortBy('barcode_type')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Type
                        </button>
                        <button wire:click="sortBy('is_active')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Status
                        </button>
                    </div>
                </div>
            </div>

            <!-- Desktop Table (md+) -->
            <div class="hidden md:block overflow-x-auto no-scrollbar scroll-hint">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3 border-b border-gray-200">
                                <input type="checkbox" wire:model.live="selectAll"
                                    class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('barcode')">
                                <div class="flex items-center gap-1">
                                    Barcode
                                    @if ($sortField === 'barcode')
                                        @if ($sortDirection === 'asc')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200">Medicine</th>
                            <th class="px-6 py-3 border-b border-gray-200 cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('barcode_type')">
                                <div class="flex items-center gap-1">
                                    Type
                                    @if ($sortField === 'barcode_type')
                                        @if ($sortDirection === 'asc')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('created_at')">
                                <div class="flex items-center gap-1">
                                    Created
                                    @if ($sortField === 'created_at')
                                        @if ($sortDirection === 'asc')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 cursor-pointer hover:bg-gray-100"
                                wire:click="sortBy('is_active')">
                                <div class="flex items-center gap-1">
                                    Status
                                    @if ($sortField === 'is_active')
                                        @if ($sortDirection === 'asc')
                                            <i class="fas fa-sort-up"></i>
                                        @else
                                            <i class="fas fa-sort-down"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort text-gray-400"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($barcodes as $barcode)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" wire:model.live="selectedItems"
                                        value="{{ $barcode->id }}"
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $barcode->barcode }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $barcode->id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $barcode->medicine->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $barcode->medicine->generic_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        {{ $barcode->barcode_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $barcode->created_at->format('d M, Y') }}
                                    <div class="text-xs text-gray-400">
                                        {{ $barcode->created_at->format('h:i A') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="toggleStatus({{ $barcode->id }})"
                                        class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-full border transition-colors
                                        {{ $barcode->is_active
                                            ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100'
                                            : 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full
                                            {{ $barcode->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $barcode->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a wire:navigate
                                            href="{{ route('admin.medicine.barcode.view', $barcode->id) }}"
                                            class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50"
                                            title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a wire:navigate
                                            href="{{ route('admin.medicine.barcode.edit', $barcode->id) }}"
                                            class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="confirmDelete({{ $barcode->id }})"
                                            class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900 mb-2">No barcodes found</p>
                                        <p class="text-sm text-gray-600 mb-4">Generate your first barcode by clicking
                                            the button above.</p>
                                        <a wire:navigate href="{{ route('admin.medicine.barcode.create') }}"
                                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition-colors">
                                            Generate Barcode
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
                @forelse($barcodes as $barcode)
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <input type="checkbox" wire:model.live="selectedItems"
                                        value="{{ $barcode->id }}"
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $barcode->barcode }}</h3>
                                        <p class="text-xs text-gray-500">ID: {{ $barcode->id }}</p>
                                    </div>
                                </div>
                                <div class="space-y-2 text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium">Medicine:</span>
                                        <span>{{ $barcode->medicine->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-1 rounded-full bg-blue-50 text-blue-700">
                                            {{ $barcode->barcode_type }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            Created: {{ $barcode->created_at->format('d M, Y') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Generic:</span>
                                        {{ $barcode->medicine->generic_name }}
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button wire:click="toggleStatus({{ $barcode->id }})"
                                        class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-full border transition-colors
                                        {{ $barcode->is_active
                                            ? 'bg-green-50 text-green-700 border-green-200'
                                            : 'bg-red-50 text-red-700 border-red-200' }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full
                                            {{ $barcode->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $barcode->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-start gap-1">
                                <a wire:navigate href="{{ route('admin.medicine.barcode.view', $barcode->id) }}"
                                    class="bg-white text-gray-500 hover:text-blue-500 p-2 rounded border border-gray-300 transition-colors"
                                    aria-label="View {{ $barcode->barcode }}">
                                    <i class="fas fa-eye text-sm" aria-hidden="true"></i>
                                </a>

                                <a wire:navigate href="{{ route('admin.medicine.barcode.edit', $barcode->id) }}"
                                    class="bg-white text-gray-500 hover:text-green-500 p-2 rounded border border-gray-300 transition-colors"
                                    aria-label="Edit {{ $barcode->barcode }}">
                                    <i class="fas fa-edit text-sm" aria-hidden="true"></i>
                                </a>
                                <button wire:click="confirmDelete({{ $barcode->id }})"
                                    class="bg-white text-gray-500 hover:text-red-500 p-2 rounded border border-gray-300 transition-colors"
                                    aria-label="Delete {{ $barcode->barcode }}">
                                    <i class="fas fa-trash text-sm" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-lg font-medium text-gray-900 mb-2">No barcodes found</p>
                        <p class="text-sm text-gray-600 mb-4">Generate your first barcode by clicking the button above.
                        </p>
                        <a wire:navigate href="{{ route('admin.medicine.barcode.create') }}"
                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition-colors">
                            Generate Barcode
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <x-common.pagination :paginator="$barcodes" :pageRange="$pageRange" />
        </div>
    </div>
</main>
