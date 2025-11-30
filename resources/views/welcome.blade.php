<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DreamsPOS - Badge Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none !important;
        }

        .no-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }
    </style>
</head>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 lg:hidden" aria-hidden="true">
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileSidebarButton"
            class="lg:hidden p-2 text-gray-800 bg-white rounded-md fixed top-3 left-4 z-50 shadow-sm"
            aria-controls="sidebar" aria-expanded="false">
            <i class="fas fa-bars text-xl" aria-hidden="true"></i>
            <span class="sr-only">Open sidebar</span>
        </button>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-white text-gray-800 shadow-xl transition-all duration-300 fixed lg:static -translate-x-full lg:translate-x-0 z-50 w-64 h-screen"
            data-collapsed="false" aria-hidden="true">
            <div class="flex h-16 items-center justify-center border-b border-gray-200">
                <div class="flex items-center gap-3 px-3">
                    <svg class="h-6 w-6 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" aria-hidden="true">
                        <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                        <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                        <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                        <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                    </svg>
                    <h1 id="sidebarTitle" class="text-xl font-bold text-orange-500">
                        AdminPro
                    </h1>
                </div>
            </div>

            <nav class="h-full overflow-y-auto p-4 no-scrollbar" aria-label="Main Navigation">
                <div class="text-sm font-semibold text-gray-500 mb-2">Main</div>
                <ul class="space-y-1">
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 font-[14px] text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" aria-hidden="true">
                                <path d="M3 12l9-9 9 9"></path>
                                <path d="M9 12v9h6v-9"></path>
                            </svg>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 font-[14px] text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" aria-hidden="true">
                                <path d="M3 12l9-9 9 9"></path>
                                <path d="M9 12v9h6v-9"></path>
                            </svg>
                            <span class="sidebar-text">Super Admin</span>
                        </a>
                    </li>
                </ul>

                <div class="my-4 border-t border-gray-100"></div>
                <div class="text-sm font-semibold text-gray-500 mb-2">Inventory</div>
                <ul class="space-y-1">
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 font-[14px] text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" aria-hidden="true">
                                <path d="M3 12l9-9 9 9"></path>
                                <path d="M9 12v9h6v-9"></path>
                            </svg>
                            <span class="sidebar-text">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 font-[14px] text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" aria-hidden="true">
                                <path d="M3 12l9-9 9 9"></path>
                                <path d="M9 12v9h6v-9"></path>
                            </svg>
                            <span class="sidebar-text">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 font-[14px] text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" aria-hidden="true">
                                <path d="M3 12l9-9 9 9"></path>
                                <path d="M9 12v9h6v-9"></path>
                            </svg>
                            <span class="sidebar-text">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 font-[14px] text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M3 12l9-9 9 9"></path>
                                <path d="M9 12v9h6v-9"></path>
                            </svg>
                            <span class="sidebar-text">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 font-[14px] text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M3 12l9-9 9 9"></path>
                                <path d="M9 12v9h6v-9"></path>
                            </svg>
                            <span class="sidebar-text">Categories</span>
                        </a>
                    </li>
                </ul>

                <div class="my-4 border-t border-gray-100"></div>
                <div class="text-sm font-semibold text-gray-500 mb-2">Reports</div>
                <ul class="space-y-1">
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 font-[14px] text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M3 12l9-9 9 9"></path>
                                <path d="M9 12v9h6v-9"></path>
                            </svg>
                            <span class="sidebar-text">Sales</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-all duration-300 font-[14px] text-gray-700 hover:bg-orange-50 hover:text-orange-500 hover:shadow-sm">
                            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M3 12l9-9 9 9"></path>
                                <path d="M9 12v9h6v-9"></path>
                            </svg>
                            <span class="sidebar-text">Analytics</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex h-16 items-center justify-between border-b bg-white px-4 sm:px-6 md:px-6 shadow-sm">
                <div class="flex items-center gap-3 sm:gap-4 flex-1">
                    <button id="toggleSidebarButton"
                        class="inline-flex items-center justify-center rounded-md text-sm font-[14px] hover:bg-gray-100 h-10 w-10 transition-colors"
                        aria-controls="sidebar" aria-expanded="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <line x1="4" x2="20" y1="12" y2="12"></line>
                            <line x1="4" x2="20" y1="6" y2="6"></line>
                            <line x1="4" x2="20" y1="18" y2="18"></line>
                        </svg>
                        <span class="sr-only">Toggle sidebar</span>
                    </button>

                    <div class="relative max-w-md w-full">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input type="search"
                            class="w-full rounded-full bg-gray-100 px-10 py-2 text-sm focus:ring-2 focus:ring-orange-500 transition-all outline-none"
                            placeholder="Search..." aria-label="Search" />
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    <button
                        class="relative h-10 w-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors"
                        aria-label="Notifications">
                        <i class="fas fa-bell text-gray-700 text-lg" aria-hidden="true"></i>
                        <span
                            class="absolute top-1 right-1 h-4 w-4 bg-blue-600 text-white text-[10px] rounded-full flex items-center justify-center">3</span>
                    </button>

                    <div class="relative">
                        <button id="profileButton"
                            class="flex items-center gap-2 hover:bg-gray-100 rounded-full px-2 py-1 transition-colors"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="https://i.pravatar.cc/40" alt="Profile"
                                class="h-8 w-8 rounded-full border border-gray-200" />
                            <span class="text-sm font-[14px] text-gray-800 hidden md:block">Admin User</span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs hidden md:block"
                                aria-hidden="true"></i>
                        </button>

                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-3 w-60 rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                            role="menu" aria-hidden="true">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">Admin User</p>
                                <p class="text-xs text-gray-500">admin@example.com</p>
                            </div>
                            <button role="menuitem"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2 focus:outline-none">
                                <i class="fas fa-sign-out-alt w-4" aria-hidden="true"></i>
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
                <div class="space-y-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">
                                Badge Categories
                            </h1>
                            <p class="text-sm text-gray-600 mt-1">
                                Manage and organize your badge categories
                            </p>
                        </div>

                        <div class="flex items-center gap-3 flex-wrap">
                            <button type="button"
                                class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                                <!-- Inline PDF SVG -->
                                <img src="assets/img/icons/pdf.svg" alt="" />
                                <span class="hidden sm:inline">Export PDF</span>
                            </button>
                            <button type="button"
                                class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                                <!-- Inline Excel SVG -->
                                <img src="assets/img/icons/excel.svg" alt="" />
                                <span class="hidden sm:inline">Export Excel</span>
                            </button>
                            <button type="button"
                                class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                </svg>
                                <span class="hidden sm:inline">Add Category</span>
                            </button>
                        </div>
                    </div>

                    <!-- Table Card -->
                    <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex flex-col md:flex-row gap-3 md:gap-4 items-center">
                                <div class="relative flex-1 max-w-xs w-full">
                                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"
                                        aria-hidden="true"></i>
                                    <input type="search"
                                        class="w-full h-9 pl-9 pr-3 text-sm rounded-md border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500 transition-all"
                                        placeholder="Search categories..." aria-label="Search categories" />
                                </div>
                                <select
                                    class="h-9 pl-2 pr-8 rounded-md border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500"
                                    aria-label="Items per page">
                                    <option>5 per page</option>
                                    <option selected>10 per page</option>
                                    <option>25 per page</option>
                                    <option>50 per page</option>
                                    <option>100 per page</option>
                                </select>
                                <div class="flex gap-2 flex-wrap">
                                    <button
                                        class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all text-sm flex items-center px-3 py-2 gap-2 rounded border border-gray-300">
                                        Email
                                    </button>
                                    <button
                                        class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all text-sm flex items-center px-3 py-2 gap-2 rounded border border-gray-300">
                                        Status
                                    </button>
                                    <button
                                        class="bg-white text-gray-500 hover:text-orange-500 active:scale-95 transition-all text-sm flex items-center px-3 py-2 gap-2 rounded border border-gray-300">
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
                                        <th scope="col" class="px-5 py-3">Name</th>
                                        <th scope="col" class="px-5 py-3">Threshold</th>
                                        <th scope="col" class="px-5 py-3">Points</th>
                                        <th scope="col" class="px-5 py-3">Status</th>
                                        <th scope="col" class="px-5 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <!-- Row 1 -->
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE001</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900">
                                            Bronze Level
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">100</td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-50 border border-green-200">
                                                <span class="text-sm font-semibold text-green-700">50</span>
                                                <span class="text-xs text-green-600">XP</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="View Bronze Level">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Edit Bronze Level">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Delete Bronze Level">
                                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Row 2 -->
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE002</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900">
                                            Silver Level
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">250</td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 border border-blue-200">
                                                <span class="text-sm font-semibold text-blue-700">100</span>
                                                <span class="text-xs text-blue-600">XP</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="View Silver Level">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Edit Silver Level">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Delete Silver Level">
                                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE002</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900">
                                            Silver Level
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">250</td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 border border-blue-200">
                                                <span class="text-sm font-semibold text-blue-700">100</span>
                                                <span class="text-xs text-blue-600">XP</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="View Silver Level">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Edit Silver Level">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Delete Silver Level">
                                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE002</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900">
                                            Silver Level
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">250</td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 border border-blue-200">
                                                <span class="text-sm font-semibold text-blue-700">100</span>
                                                <span class="text-xs text-blue-600">XP</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="View Silver Level">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Edit Silver Level">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Delete Silver Level">
                                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE002</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900">
                                            Silver Level
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">250</td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 border border-blue-200">
                                                <span class="text-sm font-semibold text-blue-700">100</span>
                                                <span class="text-xs text-blue-600">XP</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="View Silver Level">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Edit Silver Level">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Delete Silver Level">
                                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE002</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900">
                                            Silver Level
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">250</td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 border border-blue-200">
                                                <span class="text-sm font-semibold text-blue-700">100</span>
                                                <span class="text-xs text-blue-600">XP</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="View Silver Level">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Edit Silver Level">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Delete Silver Level">
                                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE002</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900">
                                            Silver Level
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">250</td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 border border-blue-200">
                                                <span class="text-sm font-semibold text-blue-700">100</span>
                                                <span class="text-xs text-blue-600">XP</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="View Silver Level">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Edit Silver Level">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Delete Silver Level">
                                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE002</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900">
                                            Silver Level
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">250</td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 border border-blue-200">
                                                <span class="text-sm font-semibold text-blue-700">100</span>
                                                <span class="text-xs text-blue-600">XP</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="View Silver Level">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Edit Silver Level">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Delete Silver Level">
                                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE002</span>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900">
                                            Silver Level
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">250</td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 border border-blue-200">
                                                <span class="text-sm font-semibold text-blue-700">100</span>
                                                <span class="text-xs text-blue-600">XP</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="View Silver Level">
                                                    <i class="far fa-eye" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Edit Silver Level">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                </button>
                                                <button
                                                    class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                                    aria-label="Delete Silver Level">
                                                    <i class="far fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards (visible < md) -->
                        <div class="md:hidden divide-y divide-gray-100">
                            <!-- Card 1 -->
                            <div class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE001</span>
                                            <h3 class="text-sm font-semibold text-gray-900 truncate">
                                                Bronze Level
                                            </h3>
                                        </div>
                                        <div class="mt-2 text-xs text-gray-600 flex flex-wrap gap-2">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-[14px]">Threshold:</span>
                                                <span>100</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-[14px]">Points:</span>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-green-50 border border-green-200">
                                                    <span class="text-sm font-semibold text-green-700">50</span>
                                                    <span class="text-xs text-green-600">XP</span>
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-[14px]">Status:</span>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                    Active
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-2">
                                        <button
                                            class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                            aria-label="View Bronze Level">
                                            <i class="far fa-eye" aria-hidden="true"></i>
                                        </button>
                                        <button
                                            class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                            aria-label="Edit Bronze Level">
                                            <i class="far fa-edit" aria-hidden="true"></i>
                                        </button>
                                        <button
                                            class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                            aria-label="Delete Bronze Level">
                                            <i class="far fa-trash-alt" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">BADGE002</span>
                                            <h3 class="text-sm font-semibold text-gray-900 truncate">
                                                Silver Level
                                            </h3>
                                        </div>
                                        <div class="mt-2 text-xs text-gray-600 flex flex-wrap gap-2">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-[14px]">Threshold:</span>
                                                <span>250</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-[14px]">Points:</span>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded bg-blue-50 border border-blue-200">
                                                    <span class="text-sm font-semibold text-blue-700">100</span>
                                                    <span class="text-xs text-blue-600">XP</span>
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-[14px]">Status:</span>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-sm font-[14px] rounded bg-green-50 text-green-700 border border-green-200">
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                    Active
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-2">
                                        <button
                                            class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                            aria-label="View Silver Level">
                                            <i class="far fa-eye" aria-hidden="true"></i>
                                        </button>
                                        <button
                                            class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                            aria-label="Edit Silver Level">
                                            <i class="far fa-edit" aria-hidden="true"></i>
                                        </button>
                                        <button
                                            class="bg-white text-gray-500 hover:text-orange-500 p-2 rounded border border-gray-300"
                                            aria-label="Delete Silver Level">
                                            <i class="far fa-trash-alt" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200">
                            <div class="text-sm text-gray-700">
                                Showing 1 to 2 of 2 entries
                            </div>
                            <div class="flex items-center gap-2">
                                <button
                                    class="px-3 py-1.5 text-xs font-[14px] text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50"
                                    aria-label="Previous page">
                                    Previous
                                </button>
                                <button class="px-3 py-1.5 text-xs font-[14px] text-white bg-orange-500 rounded"
                                    aria-current="page" aria-label="Page 1">
                                    1
                                </button>
                                <button
                                    class="px-3 py-1.5 text-xs font-[14px] text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50"
                                    aria-label="Next page">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
