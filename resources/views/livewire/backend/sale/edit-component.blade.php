<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Edit Sale #{{ $sale->invoice_number }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Update sale information
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a wire:navigate href="{{ route('admin.sales.view', $sale->id) }}"
                    class="bg-white text-gray-700 hover:bg-gray-50 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <i class="far fa-eye"></i>
                    <span class="hidden sm:inline">View Sale</span>
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

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Sale Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Medicine Items Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Sale Items</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr class="text-xs font-semibold text-gray-600 uppercase">
                                    <th class="px-4 py-3 text-left">Medicine</th>
                                    <th class="px-4 py-3 text-left">Quantity</th>
                                    <th class="px-4 py-3 text-left">Unit Price</th>
                                    <th class="px-4 py-3 text-left">Total</th>
                                    <th class="px-4 py-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($sale->saleItems as $item)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->medicine->name }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $item->medicine->generic_name }}
                                            </div>
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
                                        <td class="px-4 py-3">
                                            <button type="button" wire:click="removeItem({{ $item->id }})"
                                                class="text-red-600 hover:text-red-800">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Customer Details Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                            <input type="text" wire:model="customerName"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Phone</label>
                            <input type="tel" wire:model="customerPhone"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea wire:model="notes" rows="3"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Summary -->
            <div class="space-y-6">
                <!-- Sale Summary Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Sale Summary</h2>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Sub Total</span>
                            <span class="font-medium">৳{{ number_format($sale->sub_total, 2) }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Discount</span>
                            <span class="font-medium">৳{{ number_format($sale->discount, 2) }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Tax Amount</span>
                            <span class="font-medium">৳{{ number_format($sale->tax_amount, 2) }}</span>
                        </div>

                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Grand Total</span>
                                <span class="text-xl font-bold text-orange-600">
                                    ৳{{ number_format($sale->grand_total, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Details Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Details</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                            <select wire:model="paymentMethod"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                                @foreach (['cash', 'card', 'mobile_banking', 'other'] as $method)
                                    <option value="{{ $method }}"
                                        {{ $sale->payment_method == $method ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $method)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select wire:model="status"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                                @foreach (['completed', 'pending', 'cancelled'] as $statusOption)
                                    <option value="{{ $statusOption }}"
                                        {{ $sale->status == $statusOption ? 'selected' : '' }}>
                                        {{ ucfirst($statusOption) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sale Date</label>
                            <input type="date" wire:model="saleDate"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500" />
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <div class="space-y-3">
                        <button type="button" wire:click="updateSale"
                            class="w-full bg-orange-500 text-white hover:bg-orange-600 py-3 rounded-lg text-sm font-medium transition-colors">
                            Update Sale
                        </button>
                        <button type="button" wire:click="printInvoice"
                            class="w-full bg-blue-500 text-white hover:bg-blue-600 py-3 rounded-lg text-sm font-medium transition-colors">
                            Print Invoice
                        </button>
                        @if ($sale->status == 'pending')
                            <button type="button" wire:click="completeSale"
                                class="w-full bg-green-500 text-white hover:bg-green-600 py-3 rounded-lg text-sm font-medium transition-colors">
                                Mark as Complete
                            </button>
                        @endif
                        @if ($sale->status != 'cancelled')
                            <button type="button" wire:click="cancelSale"
                                class="w-full bg-red-500 text-white hover:bg-red-600 py-3 rounded-lg text-sm font-medium transition-colors">
                                Cancel Sale
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
