<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Sale Invoice #{{ $sale->invoice_number }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    View sale details and invoice
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <button type="button" wire:click="printInvoice"
                    class="bg-white text-gray-700 hover:bg-gray-50 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span class="hidden sm:inline">Print Invoice</span>
                </button>
                <a wire:navigate href="{{ route('admin.sales.edit', $sale->id) }}"
                    class="bg-orange-500 text-white hover:bg-orange-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-orange-500">
                    <i class="far fa-edit"></i>
                    <span class="hidden sm:inline">Edit Sale</span>
                </a>
                <a wire:navigate href="{{ route('admin.sales.index') }}"
                    class="bg-white text-gray-700 hover:bg-gray-50 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Back to Sales</span>
                </a>
            </div>
        </div>

        <!-- Invoice Card -->
        <div class="bg-white rounded-lg border border-gray-100 shadow-sm mb-6">
            <!-- Invoice Header -->
            <div class="border-b border-gray-200 p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">INVOICE</h2>
                        <div class="mt-2 space-y-1">
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Invoice #:</span> {{ $sale->invoice_number }}
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Date:</span> {{ $sale->sale_date->format('F d, Y') }}
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Status:</span>
                                <span
                                    class="ml-2 px-2 py-1 text-xs rounded-full
                                    {{ $sale->status === 'completed'
                                        ? 'bg-green-100 text-green-800'
                                        : ($sale->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="text-lg font-bold text-gray-900">Your Pharmacy Name</div>
                        <div class="text-sm text-gray-600 mt-1">123 Pharmacy Street</div>
                        <div class="text-sm text-gray-600">Dhaka, Bangladesh</div>
                        <div class="text-sm text-gray-600">Phone: +880 1234 567890</div>
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="p-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Information -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3">
                            Customer Information
                        </h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm font-medium text-gray-700">Name:</span>
                                <span class="text-sm text-gray-900 ml-2">
                                    {{ $sale->customer_name ?? 'Walk-in Customer' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Phone:</span>
                                <span class="text-sm text-gray-900 ml-2">
                                    {{ $sale->customer_phone ?? 'N/A' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Sale By:</span>
                                <span class="text-sm text-gray-900 ml-2">
                                    {{ $sale->user->name ?? 'N/A' }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Branch:</span>
                                <span class="text-sm text-gray-900 ml-2">
                                    {{ $sale->branch->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-3">
                            Payment Information
                        </h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm font-medium text-gray-700">Payment Method:</span>
                                <span class="text-sm text-gray-900 ml-2 capitalize">
                                    {{ str_replace('_', ' ', $sale->payment_method) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Sub Total:</span>
                                <span class="text-sm text-gray-900 ml-2">
                                    ৳{{ number_format($sale->sub_total, 2) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Discount:</span>
                                <span class="text-sm text-gray-900 ml-2">
                                    ৳{{ number_format($sale->discount, 2) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Tax Amount:</span>
                                <span class="text-sm text-gray-900 ml-2">
                                    ৳{{ number_format($sale->tax_amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">
                    Items Details
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-semibold text-gray-600 uppercase">
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Medicine</th>
                                <th class="px-4 py-3 text-left">Generic Name</th>
                                <th class="px-4 py-3 text-left">Quantity</th>
                                <th class="px-4 py-3 text-left">Unit Price</th>
                                <th class="px-4 py-3 text-left">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($sale->saleItems as $index => $item)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $item->medicine->name }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $item->medicine->generic_name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        ৳{{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                        ৳{{ number_format($item->total_amount, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total Section -->
            <div class="p-6">
                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sub Total:</span>
                                <span class="font-medium">৳{{ number_format($sale->sub_total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount:</span>
                                <span class="font-medium text-red-600">-৳{{ number_format($sale->discount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax Amount:</span>
                                <span class="font-medium">৳{{ number_format($sale->tax_amount, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between text-lg font-bold">
                                    <span class="text-gray-900">Grand Total:</span>
                                    <span class="text-orange-600">৳{{ number_format($sale->grand_total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if ($sale->notes)
                <div class="border-t border-gray-200 p-6 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-2">
                        Notes
                    </h3>
                    <p class="text-sm text-gray-600">{{ $sale->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
            <div class="flex flex-wrap gap-3">
                @if ($sale->status == 'pending')
                    <button type="button" wire:click="completeSale"
                        class="bg-green-500 text-white hover:bg-green-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-4 py-2 gap-2 rounded">
                        <i class="fas fa-check-circle"></i>
                        Mark as Complete
                    </button>
                @endif

                @if ($sale->status != 'cancelled')
                    <button type="button" wire:click="cancelSale"
                        class="bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-4 py-2 gap-2 rounded">
                        <i class="fas fa-times-circle"></i>
                        Cancel Sale
                    </button>
                @endif

                <a wire:navigate href="{{ route('admin.sales.edit', $sale->id) }}"
                    class="bg-blue-500 text-white hover:bg-blue-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-4 py-2 gap-2 rounded">
                    <i class="fas fa-edit"></i>
                    Edit Sale
                </a>
            </div>
        </div>
    </div>
</main>
