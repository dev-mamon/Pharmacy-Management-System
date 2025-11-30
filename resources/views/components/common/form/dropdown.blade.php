<div class="relative flex flex-col w-44 text-sm">

    <!-- Trigger Button -->
    <button type="button" @click="{{ $toggle }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition text-sm font-medium min-w-[120px] justify-between w-full">
        <div class="flex items-center gap-2">
            {!! $icon !!}
            <span>{{ $label }}</span>
        </div>

        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{{ $open }} ? 'rotate-180' : ''"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Body -->
    <ul x-show="{{ $open }}" x-transition @click.outside="{{ $open }} = false"
        class="absolute z-50 w-full bg-white border border-gray-300 rounded shadow-md mt-1 py-2">
        @foreach ($items as $item)
            <li class="px-4 py-2 hover:bg-indigo-500 hover:text-white cursor-pointer"
                wire:click="{{ $onSelect ?? '' }}('{{ $item }}')">
                {{ $item }}
            </li>
        @endforeach
    </ul>

</div>
