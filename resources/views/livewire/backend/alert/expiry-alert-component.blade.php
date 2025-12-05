<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Expiry Alerts
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Monitor and manage medicine expiry alerts
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                @if (count($selectedAlerts) > 0)
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">
                            {{ count($selectedAlerts) ?? 0 }} selected
                        </span>
                        <button wire:click="markAllAsNotified"
                            class="bg-green-500 text-white hover:bg-green-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-green-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="hidden sm:inline">Mark as Notified</span>
                        </button>
                        <button wire:click="deleteSelectedAlerts"
                            wire:confirm="Are you sure you want to delete selected alerts?"
                            class="bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span class="hidden sm:inline">Delete Selected</span>
                        </button>
                    </div>
                @endif

                <button type="button" wire:click="$refresh"
                    class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="hidden sm:inline">Refresh Alerts</span>
                </button>
            </div>
        </div>

        <!-- Alert Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <!-- Total Alerts Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Alerts</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-5 5v-5zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Critical Alerts Card -->
            <div class="bg-white rounded-lg border border-red-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Critical</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['critical'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Warning Alerts Card -->
            <div class="bg-white rounded-lg border border-orange-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Warning</p>
                        <p class="text-2xl font-bold text-orange-600 mt-1">{{ $stats['warning'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Info Alerts Card -->
            <div class="bg-white rounded-lg border border-blue-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Info</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['info'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- add alert button -->
            <!-- Notified Alerts -->
            <div class="bg-white rounded-lg border border-green-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Notified</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['notified'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Alerts -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-600 mt-1">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                        <div class="relative w-full md:w-auto max-w-xs">
                            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                            <input type="search" wire:model.live="search"
                                class="w-full h-10 pl-10 pr-3 text-sm rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="Search alerts..." />
                        </div>

                        <!-- Alert Level Filter -->
                        <div class="relative w-full md:w-auto">
                            <select wire:model.live="alertLevelFilter"
                                class="h-10 w-full md:w-40 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                @foreach ($alertLevels as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Branch Filter -->
                        <div class="relative w-full md:w-auto">
                            <select wire:model.live="branchFilter"
                                class="h-10 w-full md:w-48 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="">All Branches</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Items Per Page -->
                        <div class="relative w-full md:w-auto">
                            <select wire:model.live="perPage"
                                class="h-10 w-full md:w-24 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Clear Filters -->
                        <button wire:click="clearFilters"
                            class="h-10 w-full md:w-auto px-4 text-sm text-gray-600 hover:text-orange-500 border border-gray-300 rounded-lg hover:border-orange-300 transition-colors">
                            Clear Filters
                        </button>
                    </div>


                    <!-- Right Section: Sort Buttons -->
                    <div class="flex gap-2 flex-wrap justify-end">
                        <button wire:click="sortBy('days_until_expiry')"
                            class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                            Days Left
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
                            <th scope="col" class="px-5 py-3 w-8">
                                <input type="checkbox" wire:model.live="selectAll"
                                    class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                            </th>
                            <th scope="col" class="px-5 py-3">Medicine</th>
                            <th scope="col" class="px-5 py-3">Branch</th>
                            <th scope="col" class="px-5 py-3">Batch No</th>
                            <th scope="col" class="px-5 py-3">Expiry Date</th>
                            <th scope="col" class="px-5 py-3">Days Left</th>
                            <th scope="col" class="px-5 py-3">Alert Level</th>
                            <th scope="col" class="px-5 py-3">Status</th>
                            <th scope="col" class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($alerts as $alert)
                            <tr
                                class="hover:bg-gray-50 transition-colors {{ in_array($alert->id, $selectedAlerts) ? 'bg-orange-50' : '' }}">
                                <td class="px-5 py-3">
                                    <input type="checkbox" wire:model.live="selectedAlerts"
                                        value="{{ $alert->id }}"
                                        class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
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
                                            <div class="font-medium text-gray-900">
                                                {{ $alert->stock->medicine->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">Stock:
                                                {{ $alert->stock->quantity ?? 0 }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-600">
                                    <span class="font-medium">{{ $alert->branch->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-5 py-3">
                                    <span
                                        class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $alert->stock->batch_number ?? 'N/A' }}</span>
                                </td>
                                <td class="px-5 py-3 text-sm">
                                    <span
                                        class="{{ $alert->days_until_expiry <= 7 ? 'text-red-600 font-semibold' : ($alert->days_until_expiry <= 30 ? 'text-orange-600' : 'text-gray-600') }}">
                                        {{ $alert->expiry_date->format('M d, Y') }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $alert->days_until_expiry <= 7
                                            ? 'bg-red-100 text-red-800'
                                            : ($alert->days_until_expiry <= 30
                                                ? 'bg-orange-100 text-orange-800'
                                                : 'bg-blue-100 text-blue-800') }}">
                                        {{ $alert->days_until_expiry }} days
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    @php
                                        $alertStyles = [
                                            'critical' => 'bg-red-100 text-red-800 border-red-200',
                                            'warning' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'info' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full border {{ $alertStyles[$alert->alert_level] }}">
                                        @if ($alert->alert_level === 'critical')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                            </svg>
                                        @elseif($alert->alert_level === 'warning')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                        {{ ucfirst($alert->alert_level) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    @if ($alert->is_notified)
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 border border-green-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Notified
                                            @if ($alert->notified_at)
                                                <span
                                                    class="text-xs">({{ $alert->notified_at->diffForHumans() }})</span>
                                            @endif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if (!$alert->is_notified)
                                            <button wire:click="markAsNotified({{ $alert->id }})"
                                                class="p-2 rounded bg-green-50 text-green-600 hover:bg-green-100 transition-colors"
                                                title="Mark as Notified">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        @endif
                                        <button wire:click="deleteAlert({{ $alert->id }})"
                                            wire:confirm="Are you sure you want to delete this alert?"
                                            class="p-2 rounded bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            title="Delete Alert">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
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
                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900 mb-2">No expiry alerts found</p>
                                        <p class="text-sm text-gray-600">All medicines are properly stocked with valid
                                            expiry dates.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards (visible < md) -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($alerts as $alert)
                    <!-- Card Container -->
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 mb-3 overflow-hidden transition-all duration-200
        {{ in_array($alert->id, $selectedAlerts) ? 'border-orange-300 bg-orange-50 ring-1 ring-orange-200' : '' }}">

                        <!-- Selected Indicator -->
                        @if (in_array($alert->id, $selectedAlerts))
                            <div class="h-1 w-full bg-gradient-to-r from-orange-400 to-orange-500"></div>
                        @endif

                        <div class="p-4">
                            <!-- Top Section - Medicine & Batch -->
                            <div class="flex items-start justify-between mb-4">
                                <!-- Medicine Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <!-- Medicine Icon -->
                                        <div class="p-2 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                            </svg>
                                        </div>

                                        <!-- Medicine Name -->
                                        <h3 class="text-base font-semibold text-gray-900 truncate">
                                            {{ $alert->stock->medicine->name ?? 'N/A' }}
                                        </h3>
                                    </div>

                                    <!-- Branch & Batch -->
                                    <div class="flex items-center gap-2 ml-11">
                                        <span
                                            class="px-2 py-0.5 bg-gray-100 rounded text-xs text-gray-600 font-medium">
                                            {{ $alert->branch->name ?? 'N/A' }}
                                        </span>
                                        <span class="text-xs text-gray-500">• Batch:
                                            {{ $alert->stock->batch_number ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <!-- Checkbox -->
                                <label class="relative flex items-center cursor-pointer ml-2">
                                    <input type="checkbox" wire:model.live="selectedAlerts"
                                        value="{{ $alert->id }}" class="sr-only peer">
                                    <div
                                        class="w-5 h-5 border-2 border-gray-300 rounded-md peer-checked:bg-orange-500
                                peer-checked:border-orange-500 peer-checked:text-white
                                flex items-center justify-center transition-all duration-200">
                                        <svg class="w-3 h-3 opacity-0 peer-checked:opacity-100 transition-opacity"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </label>
                            </div>

                            <!-- Critical Info Bar -->
                            <div
                                class="mb-4 p-3 rounded-lg bg-gradient-to-r
                {{ $alert->days_until_expiry <= 7
                    ? 'from-red-50 to-red-100 border border-red-200'
                    : ($alert->days_until_expiry <= 30
                        ? 'from-orange-50 to-orange-100 border border-orange-200'
                        : 'from-blue-50 to-blue-100 border border-blue-200') }}">

                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <!-- Expiry Icon -->
                                            <svg class="w-4 h-4
                                {{ $alert->days_until_expiry <= 7
                                    ? 'text-red-600'
                                    : ($alert->days_until_expiry <= 30
                                        ? 'text-orange-600'
                                        : 'text-blue-600') }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>

                                            <!-- Days Left -->
                                            <span
                                                class="text-sm font-bold
                                {{ $alert->days_until_expiry <= 7
                                    ? 'text-red-700'
                                    : ($alert->days_until_expiry <= 30
                                        ? 'text-orange-700'
                                        : 'text-blue-700') }}">
                                                {{ $alert->days_until_expiry }} days left
                                            </span>
                                        </div>

                                        <!-- Expiry Date -->
                                        <div
                                            class="text-xs
                            {{ $alert->days_until_expiry <= 7
                                ? 'text-red-600'
                                : ($alert->days_until_expiry <= 30
                                    ? 'text-orange-600'
                                    : 'text-blue-600') }}">
                                            Expires: {{ $alert->expiry_date->format('M d, Y') }}
                                        </div>
                                    </div>

                                    <!-- Alert Level Badge -->
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold
                        {{ $alert->alert_level === 'critical'
                            ? 'bg-red-600 text-white'
                            : ($alert->alert_level === 'warning'
                                ? 'bg-orange-600 text-white'
                                : 'bg-blue-600 text-white') }}">
                                        {{ ucfirst($alert->alert_level) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Bottom Action Row -->
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <!-- Left Side - Stock & Status -->
                                <div class="space-y-2">
                                    <!-- Stock Quantity -->
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <span class="text-sm text-gray-700">
                                            <span class="font-semibold">{{ $alert->stock->quantity ?? 0 }}</span> in
                                            stock
                                        </span>
                                    </div>

                                    <!-- Notification Status -->
                                    <div class="flex items-center gap-2">
                                        @if ($alert->is_notified)
                                            <div class="flex items-center gap-1 text-green-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-xs font-medium">Notified</span>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1 text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-xs">Pending</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Right Side - Action Buttons -->
                                <div class="flex items-center gap-2">
                                    @if (!$alert->is_notified)
                                        <!-- Mark as Notified Button -->
                                        <button wire:click="markAsNotified({{ $alert->id }})"
                                            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-green-600
                                       text-white rounded-lg hover:from-green-600 hover:to-green-700
                                       active:scale-95 transition-all duration-200 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-sm font-medium">Mark Done</span>
                                        </button>
                                    @endif

                                    <!-- Delete Button -->
                                    <button wire:click="deleteAlert({{ $alert->id }})"
                                        wire:confirm="Are you sure you want to delete this alert?"
                                        class="p-2.5 rounded-lg bg-gradient-to-br from-gray-50 to-gray-100
                                   text-red-600 hover:from-red-50 hover:to-red-100
                                   active:scale-95 transition-all duration-200 shadow-sm border border-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                        <div
                            class="w-20 h-20 mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full
                    flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No expiry alerts</h3>
                        <p class="text-gray-500 text-sm max-w-xs">All medicines are within safe expiry range</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <x-common.pagination :paginator="$alerts" :pageRange="$pageRange" />
        </div>
    </div>
</main>
