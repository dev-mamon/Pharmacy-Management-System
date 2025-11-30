<div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-white">
    <div class="text-sm text-gray-700">
        Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }}
        entries
    </div>

    <div class="flex items-center gap-2">
        {{-- First Page --}}
        @if ($paginator->onFirstPage())
            <button disabled
                class="px-3 py-1.5 text-xs text-gray-700 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
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
                class="px-3 py-1.5 text-xs text-gray-700 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                Previous
            </button>
        @else
            <button wire:click.prevent="previousPage"
                class="px-3 py-1.5 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                Previous
            </button>
        @endif

        {{-- Page Numbers --}}
        @foreach ($pageRange as $page)
            @if ($page == $paginator->currentPage())
                <button class="px-3 py-1.5 text-xs text-white bg-orange-500 rounded">
                    {{ $page }}
                </button>
            @else
                <button wire:click.prevent="gotoPage({{ $page }})"
                    class="px-3 py-1.5 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                    {{ $page }}
                </button>
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <button wire:click.prevent="nextPage"
                class="px-3 py-1.5 text-xs text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                Next
            </button>
        @else
            <button disabled
                class="px-3 py-1.5 text-xs text-gray-700 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                Next
            </button>
        @endif

        {{-- Last Page --}}
        @if ($paginator->currentPage() == $paginator->lastPage())
            <button disabled
                class="px-3 py-1.5 text-xs text-gray-700 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
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
