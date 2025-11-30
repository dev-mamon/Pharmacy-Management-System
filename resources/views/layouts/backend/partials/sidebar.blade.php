<aside @mouseenter="sidebarHovered = true" @mouseleave="sidebarHovered = false"
    :class="[
        'bg-white text-gray-800 shadow-xl transition-all duration-300 fixed lg:static z-50 h-screen',
        mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
        (sidebarCollapsed && !sidebarHovered) ? 'sidebar-collapsed' : 'sidebar-expanded'
    ]">
    <div class="flex h-16 items-center justify-center border-b border-gray-200">
        <div class="flex items-center gap-3 px-3">
            <svg class="h-6 w-6 text-orange-500 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3">
                </path>
            </svg>
            <h1 x-show="!sidebarCollapsed || sidebarHovered" x-transition
                class="text-xl font-bold text-orange-500 whitespace-nowrap">
                PharmaCare
            </h1>
        </div>
    </div>

    <nav class="h-full overflow-y-auto p-4 no-scrollbar pb-20">
        <!-- Main Menu -->
        <div x-show="!sidebarCollapsed || sidebarHovered" x-transition class="text-sm font-semibold text-gray-500 mb-2">
            Main
        </div>
        <ul class="space-y-1">
            <li>
                <a wire:navigate href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M3 12l9-9 9 9"></path>
                        <path d="M9 12v9h6v-9"></path>
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Dashboard
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.branches.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M17 9V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2m2 4h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2zm7-5a2 2 0 1 1-4 0 2 2 0 0 1 4 0z">
                        </path>
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Branches
                    </span>
                </a>
            </li>
        </ul>

        <div class="my-4 border-t border-gray-100"></div>

        <!-- Inventory Management -->
        <div x-show="!sidebarCollapsed || sidebarHovered" x-transition class="text-sm font-semibold text-gray-500 mb-2">
            Inventory
        </div>
        <ul class="space-y-1">
            <li>
                <a wire:navigate href="{{ route('admin.medicines.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M20 12v10H4V12M2 7h20v5H2zm10 15V7m0 0H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7zm0 0h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z">
                        </path>
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Medicines
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Categories
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.suppliers.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect width="7" height="7" x="3" y="3" rx="1" />
                        <rect width="7" height="7" x="14" y="3" rx="1" />
                        <rect width="7" height="7" x="14" y="14" rx="1" />
                        <rect width="7" height="7" x="3" y="14" rx="1" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Suppliers
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.stocks.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                        <line x1="9" x2="9" y1="3" y2="21" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Stock Management
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.purchases.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Purchases
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.low-stock.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Low Stock Alerts
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.expiry-alerts.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" x2="9" y1="9" y2="15" />
                        <line x1="9" x2="15" y1="9" y2="15" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Expiry Alerts
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.stock-transfers.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M8 17l4 4 4-4m-4-4v12M3 3h18M3 9h18M3 15h18"></path>
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Stock Transfers
                    </span>
                </a>
            </li>
        </ul>

        <div class="my-4 border-t border-gray-100"></div>

        <!-- Sales & POS -->
        <div x-show="!sidebarCollapsed || sidebarHovered" x-transition
            class="text-sm font-semibold text-gray-500 mb-2">
            Sales & POS
        </div>
        <ul class="space-y-1">
            <li>
                <a wire:navigate href="{{ route('admin.pos.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <line x1="2" x2="22" y1="10" y2="10" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        POS System
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.sales.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Sales History
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.invoices.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" x2="8" y1="13" y2="13" />
                        <line x1="16" x2="8" y1="17" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Invoices
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.returns.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 10l4-4-4-4" />
                        <path d="M3 18v-2a4 4 0 0 1 4-4h4" />
                        <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Returns
                    </span>
                </a>
            </li>
        </ul>

        <div class="my-4 border-t border-gray-100"></div>

        <!-- Customer Management -->
        <div x-show="!sidebarCollapsed || sidebarHovered" x-transition
            class="text-sm font-semibold text-gray-500 mb-2">
            Customers
        </div>
        <ul class="space-y-1">
            <li>
                <a wire:navigate href="{{ route('admin.customers.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Customers
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.prescriptions.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" x2="8" y1="13" y2="13" />
                        <line x1="16" x2="8" y1="17" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Prescriptions
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.loyalty.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Loyalty Program
                    </span>
                </a>
            </li>
        </ul>

        <div class="my-4 border-t border-gray-100"></div>

        <!-- Financial Management -->
        <div x-show="!sidebarCollapsed || sidebarHovered" x-transition
            class="text-sm font-semibold text-gray-500 mb-2">
            Financial
        </div>
        <ul class="space-y-1">
            <li>
                <a wire:navigate href="{{ route('admin.expenses.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Expenses
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.shifts.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Shift Management
                    </span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('admin.reports.sales') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                        <line x1="12" x2="12" y1="22.08" y2="12" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Reports
                    </span>
                </a>
            </li>
        </ul>

        <div class="my-4 border-t border-gray-100"></div>

        <!-- User & System Management -->
        <div x-show="!sidebarCollapsed || sidebarHovered" x-transition
            class="text-sm font-semibold text-gray-500 mb-2">
            System
        </div>
        <ul class="space-y-1">
            <li>
                <a wire:navigate href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" x2="20" y1="8" y2="14" />
                        <line x1="23" x2="17" y1="11" y2="11" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Users
                    </span>
                </a>
            </li>
            <li x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                        <span x-show="!sidebarCollapsed || sidebarHovered" x-transition
                            class="whitespace-nowrap text-sm">
                            Settings
                        </span>
                    </div>
                    <svg x-show="!sidebarCollapsed || sidebarHovered" :class="open ? 'rotate-180' : ''"
                        class="transition-all duration-300 w-4 h-4 text-gray-500 flex-shrink-0" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>

                <ul x-show="open && (!sidebarCollapsed || sidebarHovered)" x-collapse
                    class="mt-1 ms-9 space-y-1 text-[13px] text-gray-600">
                    <li>
                        <a wire:navigate href="{{ route('admin.settings.general') }}"
                            class="block rounded-md px-2 py-1 transition hover:bg-orange-50 hover:text-orange-500">
                            <svg class="inline-block me-2 h-2 w-2" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            General Settings
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('admin.settings.tax') }}"
                            class="block rounded-md px-2 py-1 transition hover:bg-orange-50 hover:text-orange-500">
                            <svg class="inline-block me-2 h-2 w-2" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            Tax Settings
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('admin.settings.discounts') }}"
                            class="block rounded-md px-2 py-1 transition hover:bg-orange-50 hover:text-orange-500">
                            <svg class="inline-block me-2 h-2 w-2" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            Discount Settings
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('admin.settings.payment') }}"
                            class="block rounded-md px-2 py-1 transition hover:bg-orange-50 hover:text-orange-500">
                            <svg class="inline-block me-2 h-2 w-2" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            Payment Methods
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a wire:navigate href="{{ route('admin.audit-logs.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" x2="8" y1="13" y2="13" />
                        <line x1="16" x2="8" y1="17" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Audit Logs
                    </span>
                </a>
            </li>

            <li>
                <a wire:navigate href="{{ route('admin.notifications.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Notifications
                    </span>
                </a>
            </li>

            <li>
                <a wire:navigate href=""
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    <span x-show="!sidebarCollapsed || sidebarHovered" x-transition class="whitespace-nowrap text-sm">
                        Logout
                    </span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Hidden logout form -->
    <form id="logout-form" action="" method="POST" class="hidden">
        @csrf
    </form>
</aside>
