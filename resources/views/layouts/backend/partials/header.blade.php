<header class="flex h-14 sm:h-16 items-center justify-between border-b bg-white px-3 sm:px-4 md:px-6 shadow-sm relative">
    <!-- Left Section -->
    <div class="flex items-center gap-2 sm:gap-3 md:gap-4 flex-1 min-w-0">
        <!-- Mobile Menu Button -->
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="lg:hidden inline-flex items-center justify-center rounded-xl text-sm bg-gray-50 hover:bg-gray-100 active:scale-95 transition-all duration-200 h-10 w-10">
            <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Desktop Menu Button -->
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="hidden lg:inline-flex items-center justify-center rounded-xl text-sm bg-gray-50 hover:bg-gray-100 active:scale-95 transition-all duration-200 h-10 w-10">
            <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Brand/Logo - Hidden on mobile when search is open -->
        <div class="hidden sm:block flex-shrink-0" x-show="!searchOpen">
            <h1 class="text-lg font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">
                PharmaCare
            </h1>
        </div>

        <!-- Search Bar -->
        <div class="relative w-full max-w-2xl" x-data="{
            searchOpen: false,
            searchQuery: '',
            recentSearches: ['Paracetamol', 'Vitamin C', 'Amoxicillin'],
            popularSearches: ['COVID Test', 'Blood Pressure', 'Diabetes', 'Pain Relief']
        }">
            <!-- Mobile Search Trigger -->
            <button @click="searchOpen = true" x-show="!searchOpen"
                class="lg:hidden w-full flex items-center gap-3 px-4 py-2.5 bg-gray-50 hover:bg-gray-100 rounded-2xl border border-gray-200 transition-all duration-200 active:scale-95">
                <svg class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <span class="text-gray-500 text-sm flex-1 text-left">Search medicines, products...</span>
                <kbd
                    class="hidden xs:inline-flex items-center px-1.5 py-0.5 text-xs bg-white border border-gray-300 rounded-md text-gray-500">
                    ⌘K
                </kbd>
            </button>

            <!-- Desktop Search Input -->
            <div class="hidden lg:block relative">
                <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input type="search" x-model="searchQuery"
                    class="w-full rounded-2xl bg-gray-50 border border-gray-200 px-12 py-2.5 text-sm focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 outline-none placeholder-gray-500"
                    placeholder="Search medicines, products, categories..." />
                <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1">
                    <kbd
                        class="hidden xl:inline-flex items-center px-1.5 py-0.5 text-xs bg-white border border-gray-300 rounded-md text-gray-500">
                        ⌘K
                    </kbd>
                </div>
            </div>

            <!-- Mobile Search Overlay -->
            <div x-show="searchOpen" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                class="fixed inset-0 bg-white z-50 lg:hidden flex flex-col">

                <!-- Search Header -->
                <div class="flex items-center gap-3 p-4 border-b border-gray-100 bg-white">
                    <button @click="searchOpen = false"
                        class="p-2 rounded-xl hover:bg-gray-50 active:scale-95 transition-all duration-200">
                        <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input type="search" x-model="searchQuery" @input.debounce.300ms="handleSearch"
                            class="w-full rounded-2xl bg-gray-50 border border-gray-200 px-12 py-3 text-base focus:bg-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all duration-200 outline-none placeholder-gray-500"
                            placeholder="Search medicines, products..." autofocus x-ref="searchInput" />
                        <button x-show="searchQuery" @click="searchQuery = ''"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Search Content -->
                <div class="flex-1 overflow-y-auto bg-gray-50">
                    <template x-if="!searchQuery">
                        <div class="p-4 space-y-6">
                            <!-- Recent Searches -->
                            <div x-show="recentSearches.length > 0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-3">Recent Searches</h3>
                                <div class="space-y-2">
                                    <template x-for="search in recentSearches" :key="search">
                                        <button @click="searchQuery = search; $refs.searchInput.focus()"
                                            class="w-full flex items-center gap-3 p-3 rounded-2xl bg-white hover:bg-gray-50 border border-gray-200 transition-all duration-200 active:scale-95">
                                            <svg class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <path d="m21 21-4.3-4.3"></path>
                                            </svg>
                                            <span class="text-gray-700 text-sm" x-text="search"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Popular Searches -->
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900 mb-3">Popular Categories</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    <template x-for="search in popularSearches" :key="search">
                                        <button @click="searchQuery = search; $refs.searchInput.focus()"
                                            class="p-3 rounded-2xl bg-white hover:bg-gray-50 border border-gray-200 transition-all duration-200 active:scale-95 text-center">
                                            <span class="text-gray-700 text-sm font-medium" x-text="search"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Search Results -->
                    <template x-if="searchQuery">
                        <div class="p-4">
                            <div class="space-y-2">
                                <!-- Sample Results -->
                                <button
                                    class="w-full flex items-center gap-3 p-3 rounded-2xl bg-white hover:bg-gray-50 border border-gray-200 transition-all duration-200 active:scale-95">
                                    <div
                                        class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-pills text-blue-500 text-sm"></i>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <p class="text-sm font-semibold text-gray-900"
                                            x-text="'Results for: ' + searchQuery"></p>
                                        <p class="text-xs text-gray-500">Medicines & Healthcare products</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Section -->
    <div class="flex items-center gap-1 sm:gap-2 md:gap-3">
        <!-- Notification Bell -->
        <button class="relative group">
            <div
                class="h-10 w-10 flex items-center justify-center rounded-2xl bg-gray-50 hover:bg-gray-100 active:scale-95 transition-all duration-200">
                <i class="fas fa-bell text-gray-600 text-lg"></i>
            </div>
            <span class="absolute top-1.5 right-1.5 h-3 w-3 bg-red-500 border-2 border-white rounded-full"></span>

        </button>

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ profileOpen: false }">
            <!-- Mobile Profile -->
            <button @click="profileOpen = !profileOpen"
                class="md:hidden h-10 w-10 flex items-center justify-center rounded-2xl bg-gray-50 hover:bg-gray-100 active:scale-95 transition-all duration-200">
                <img src="https://i.pravatar.cc/150?img=32" alt="Profile"
                    class="h-7 w-7 rounded-full border-2 border-white shadow-sm" />
            </button>

            <!-- Desktop Profile -->
            <button @click="profileOpen = !profileOpen"
                class="hidden md:flex items-center gap-2 px-3 py-2 rounded-2xl bg-gray-50 hover:bg-gray-100 active:scale-95 transition-all duration-200">
                <img src="https://i.pravatar.cc/150?img=32" alt="Profile"
                    class="h-8 w-8 rounded-full border-2 border-white shadow-sm" />
                <div class="text-left">
                    <p class="text-sm font-semibold text-gray-900 leading-none">Admin</p>
                    <p class="text-xs text-gray-500 leading-none">Pharmacy</p>
                </div>
                <i class="fas fa-chevron-down text-gray-400 text-xs ml-1"></i>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="profileOpen" @click.away="profileOpen = false" x-transition
                class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-200 py-2 z-50">
                <!-- User Info -->
                <div class="px-4 py-3 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <img src="https://i.pravatar.cc/150?img=32" alt="Profile"
                            class="h-10 w-10 rounded-full border-2 border-white shadow-sm" />
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">Admin User</p>
                            <p class="text-xs text-gray-500 truncate">admin@pharmacy.com</p>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="space-y-1 px-2 py-2">
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-user text-blue-500 text-sm"></i>
                        </div>
                        <span>My Profile</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                            <i class="fas fa-cog text-green-500 text-sm"></i>
                        </div>
                        <span>Settings</span>
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                            <i class="fas fa-question-circle text-purple-500 text-sm"></i>
                        </div>
                        <span>Help & Support</span>
                    </a>
                </div>

                <!-- Logout -->
                <div class="border-t border-gray-100 mt-2 pt-2">
                    <button
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                            <i class="fas fa-sign-out-alt text-red-500 text-sm"></i>
                        </div>
                        <span>Logout</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
