<div class="px-6 py-4 border-t border-gray-200 bg-white">
    <!-- Mobile View (sm and below) -->
    <div class="sm:hidden">
        <div class="flex items-center justify-between mb-4">
            <div class="text-xs text-gray-600">
                Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
            </div>
            <div class="text-xs text-gray-700">
                {{ $paginator->total() }} total
            </div>
        </div>

        <div class="flex items-center justify-between">
            <!-- Previous Button -->
            @if ($paginator->onFirstPage())
                <button disabled
                    class="flex items-center gap-1 px-3 py-2 text-xs text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                </button>
            @else
                <button wire:click.prevent="previousPage"
                    class="flex items-center gap-1 px-3 py-2 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                </button>
            @endif

            <!-- Current Page Indicator -->
            <div class="flex items-center gap-1">
                <span class="text-sm font-medium text-gray-700">
                    {{ $paginator->currentPage() }}
                </span>
                <span class="text-xs text-gray-500">/</span>
                <span class="text-xs text-gray-600">
                    {{ $paginator->lastPage() }}
                </span>
            </div>

            <!-- Next Button -->
            @if ($paginator->hasMorePages())
                <button wire:click.prevent="nextPage"
                    class="flex items-center gap-1 px-3 py-2 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                    Next
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @else
                <button disabled
                    class="flex items-center gap-1 px-3 py-2 text-xs text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                    Next
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @endif
        </div>

        <!-- Items Count -->
        <div class="mt-3 text-center text-xs text-gray-600">
            Showing {{ $paginator->firstItem() ?? 0 }}-{{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }}
            items
        </div>
    </div>

    <!-- Desktop View (sm and above) -->
    <div class="hidden sm:flex sm:flex-col sm:gap-4">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of
                {{ $paginator->total() }}
                entries
            </div>

            <div class="flex items-center gap-1">
                {{-- First Page --}}
                @if ($paginator->onFirstPage())
                    <button disabled
                        class="px-3 py-1.5 text-xs text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                        First
                    </button>
                @else
                    <button wire:click.prevent="gotoPage(1)"
                        class="px-3 py-1.5 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                        First
                    </button>
                @endif

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <button disabled
                        class="px-3 py-1.5 text-xs text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                @else
                    <button wire:click.prevent="previousPage"
                        class="px-3 py-1.5 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                @endif

                {{-- Page Numbers --}}
                <div class="flex items-center gap-1">
                    @foreach ($pageRange as $page)
                        @if ($page == $paginator->currentPage())
                            <button
                                class="px-3 py-1.5 text-xs font-medium text-white bg-orange-500 border border-orange-500 rounded min-w-[32px]">
                                {{ $page }}
                            </button>
                        @else
                            <button wire:click.prevent="gotoPage({{ $page }})"
                                class="px-3 py-1.5 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 min-w-[32px]">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                </div>

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <button wire:click.prevent="nextPage"
                        class="px-3 py-1.5 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @else
                    <button disabled
                        class="px-3 py-1.5 text-xs text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @endif

                {{-- Last Page --}}
                @if ($paginator->currentPage() == $paginator->lastPage())
                    <button disabled
                        class="px-3 py-1.5 text-xs text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                        Last
                    </button>
                @else
                    <button wire:click.prevent="gotoPage({{ $paginator->lastPage() }})"
                        class="px-3 py-1.5 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                        Last
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
