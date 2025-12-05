<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('message') }}
            </div>
        @endif

        <!-- Header -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Purchase Details</h1>
                    <div class="flex items-center gap-4 mt-2">
                        <p class="text-sm text-gray-600">Purchase No: {{ $purchase->purchase_number }}</p>
                        <span
                            class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded-full border
                            {{ $purchase->status === 'completed'
                                ? 'bg-green-100 text-green-800 border-green-200'
                                : ($purchase->status === 'pending'
                                    ? 'bg-orange-100 text-orange-800 border-orange-200'
                                    : 'bg-red-100 text-red-800 border-red-200') }}">
                            <span
                                class="w-2 h-2 rounded-full
                                {{ $purchase->status === 'completed'
                                    ? 'bg-green-500'
                                    : ($purchase->status === 'pending'
                                        ? 'bg-orange-500'
                                        : 'bg-red-500') }}">
                            </span>
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @if ($purchase->status === 'pending')
                        <button wire:click="updateStatus('completed')"
                            wire:confirm="Are you sure you want to mark this purchase as completed? This will update your inventory."
                            class="bg-green-500 text-white hover:bg-green-600 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Mark as Completed
                        </button>
                        <button wire:click="updateStatus('cancelled')"
                            wire:confirm="Are you sure you want to cancel this purchase?"
                            class="bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel Purchase
                        </button>
                    @endif
                    <a wire:navigate href="{{ route('admin.purchases.edit', $purchase->id) }}"
                        class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <a wire:navigate href="{{ route('admin.purchases.index') }}"
                        class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Purchase Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Supplier & Branch Info -->
            <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Supplier & Branch Information</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Supplier</h3>
                        <div class="mt-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $purchase->supplier->name }}</p>
                            <p class="text-sm text-gray-600">{{ $purchase->supplier->phone ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600">{{ $purchase->supplier->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Branch</h3>
                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ $purchase->branch->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Created By</h3>
                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ $purchase->user->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">{{ $purchase->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Purchase Details -->
            <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Purchase Details</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Purchase Date</h3>
                            <p class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $purchase->purchase_date->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Total Items</h3>
                            <p class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $purchase->purchaseItems->count() }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Notes</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $purchase->notes ?? 'No notes provided' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Financial Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Subtotal</span>
                        <span class="text-sm font-semibold text-gray-900">
                            ৳{{ number_format($purchase->total_amount, 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Discount</span>
                        <span class="text-sm font-semibold text-green-600">
                            -৳{{ number_format($purchase->discount, 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Tax Amount</span>
                        <span class="text-sm font-semibold text-red-600">
                            +৳{{ number_format($purchase->tax_amount, 2) }}
                        </span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-semibold text-gray-900">Grand Total</span>
                            <span class="text-xl font-bold text-orange-600">
                                ৳{{ number_format($purchase->grand_total, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase Items -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Purchase Items</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold text-gray-600 uppercase">
                            <th class="px-6 py-3 text-left">Medicine</th>
                            <th class="px-6 py-3 text-left">Batch No</th>
                            <th class="px-6 py-3 text-left">Quantity</th>
                            <th class="px-6 py-3 text-left">Purchase Price (৳)</th>
                            <th class="px-6 py-3 text-left">Selling Price (৳)</th>
                            <th class="px-6 py-3 text-left">Expiry Date</th>
                            <th class="px-6 py-3 text-left">Total (৳)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($purchase->purchaseItems as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
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
                                                {{ $item->medicine->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $item->medicine->generic_name ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">
                                        {{ $item->batch_number }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-gray-900">{{ $item->quantity }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm text-gray-900">৳{{ number_format($item->purchase_price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm text-green-600">৳{{ number_format($item->selling_price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $isExpiring = $item->expiry_date <= now()->addDays(30);
                                        $isExpired = $item->expiry_date <= now();
                                    @endphp
                                    <span
                                        class="text-sm {{ $isExpired ? 'text-red-600' : ($isExpiring ? 'text-orange-600' : 'text-gray-600') }}">
                                        {{ \Carbon\Carbon::parse($item->expiry_date)->format('M d, Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-gray-900">
                                        ৳{{ number_format($item->total_amount, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                Total Amount:
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-lg font-bold text-orange-600">
                                    ৳{{ number_format($purchase->purchaseItems->sum('total_amount'), 2) }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>
