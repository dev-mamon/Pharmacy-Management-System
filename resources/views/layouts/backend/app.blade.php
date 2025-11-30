<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DreamsPOS - Badge Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @livewireStyles
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none !important;
        }

        .no-scrollbar {
            -ms-overflow-style: none !important;
            scrollbar-width: none !important;
        }

        [x-cloak] {
            display: none !important;
        }

        .sidebar-collapsed {
            width: 4.5rem;
        }

        .sidebar-expanded {
            width: 16rem;
        }

        .sidebar-text-hidden {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar-text-visible {
            opacity: 1;
            width: auto;
        }
    </style>
</head>

<body class="bg-gray-100" x-data="{
    sidebarCollapsed: false,
    mobileSidebarOpen: false,
    sidebarHovered: false
}">
    <div class="flex h-screen overflow-hidden">
        <div x-show="mobileSidebarOpen" x-transition.opacity @click="mobileSidebarOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden">
        </div>

        <!-- Mobile Menu Button -->
        <button @click="mobileSidebarOpen = !mobileSidebarOpen"
            class="lg:hidden p-2 text-gray-800 bg-white rounded-md fixed top-3 left-4 z-50 shadow-sm">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Sidebar -->
        @include('layouts.backend.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @include('layouts.backend.partials.header')
            <!-- Main Content Area -->
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
</body>

</html>
