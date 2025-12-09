<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Create New Sale
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Add new sale to the system
                </p>
            </div>

            <div class="flex items-center gap-3">
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
                <!-- Medicine Selection Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Medicine Selection</h2>
                        <button type="button" wire:click="addMedicineItem"
                            class="bg-orange-500 text-white hover:bg-orange-600 text-sm flex items-center px-3 py-2 gap-2 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Medicine
                        </button>
                    </div>
                    <!-- select branch -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Branch</label>
                        <select wire:model="branchId"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        @error('branchId')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Medicine Search -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Medicine</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" wire:model.live="medicineSearch"
                                class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Search medicine by name, generic name or brand..." />
                        </div>

                        <!-- Search Results -->
                        @if ($medicineSearch && $searchResults->count() > 0)
                            <div
                                class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach ($searchResults as $medicine)
                                    <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
                                        wire:click="selectMedicine({{ $medicine->id }})">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $medicine->name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $medicine->generic_name }} | {{ $medicine->category->name }}
                                                </div>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                <span class="font-medium">Stock:</span>
                                                {{ $medicine->current_stock ?? 0 }}
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Price: ৳{{ number_format($medicine->selling_price, 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($medicineSearch && $searchResults->count() === 0)
                            <div class="mt-2 text-sm text-gray-500">
                                No medicines found. Try a different search term.
                            </div>
                        @endif
                    </div>

                    <!-- Medicine Items Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr class="text-xs font-semibold text-gray-600 uppercase">
                                    <th class="px-4 py-3 text-left">Medicine</th>
                                    <th class="px-4 py-3 text-left">Stock</th>
                                    <th class="px-4 py-3 text-left">Quantity</th>
                                    <th class="px-4 py-3 text-left">Unit Price</th>
                                    <th class="px-4 py-3 text-left">Total</th>
                                    <th class="px-4 py-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($medicineItems as $index => $item)
                                    <tr wire:key="medicine-item-{{ $index }}">
                                        <td class="px-4 py-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item['medicine_name'] ?? 'Select Medicine' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $item['generic_name'] ?? '' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="text-sm {{ $item['stock_quantity'] < $item['quantity'] ? 'text-red-600' : 'text-gray-600' }}">
                                                {{ $item['stock_quantity'] ?? 0 }}
                                            </span>
                                            @if ($item['stock_quantity'] < $item['quantity'])
                                                <div class="text-xs text-red-500 mt-1">Insufficient stock!</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <button type="button"
                                                    wire:click="updateMedicineItem({{ $index }}, 'quantity', {{ max(1, ($item['quantity'] ?? 1) - 1) }})"
                                                    class="w-6 h-6 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <input type="number"
                                                    wire:model.live="medicineItems.{{ $index }}.quantity"
                                                    wire:change="calculateTotals" min="1"
                                                    max="{{ $item['stock_quantity'] ?? 1 }}"
                                                    class="w-16 px-2 py-1 text-sm text-center border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-orange-500" />
                                                <button type="button"
                                                    wire:click="updateMedicineItem({{ $index }}, 'quantity', {{ ($item['quantity'] ?? 1) + 1 }})"
                                                    class="w-6 h-6 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="number"
                                                wire:model.live="medicineItems.{{ $index }}.unit_price"
                                                wire:change="calculateTotals" min="0" step="0.01"
                                                class="w-24 px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-orange-500" />
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            ৳<span id="item-total-{{ $index }}">
                                                {{ number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <button type="button"
                                                wire:click="removeMedicineItem({{ $index }})"
                                                class="text-red-600 hover:text-red-800 transition-colors">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if (count($medicineItems) === 0)
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                <p class="mb-2">No medicines added yet.</p>
                                <p class="text-sm">Search and add medicines to create sale.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Customer Details Card -->
                <!-- Customer Details Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Details</h2>

                    <!-- Customer Search -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Customer</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" wire:model.live="customerSearch"
                                class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Search customer by name, phone or ID..." />
                            @if ($customerId)
                                <button type="button" wire:click="clearCustomer"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-500">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>

                        <!-- Customer Search Results -->
                        @if ($customerSearch && $customerResults->count() > 0)
                            <div
                                class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach ($customerResults as $customer)
                                    <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
                                        wire:click="selectCustomer({{ $customer->id }})">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $customer->phone }} | ID: {{ $customer->customer_id }}
                                                </div>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                <span class="font-medium">Spent:</span>
                                                ৳{{ number_format($customer->total_spent, 2) }}
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Points: {{ $customer->loyalty_points }} |
                                            Last Purchase: {{ $customer->updated_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($customerSearch && $customerResults->count() === 0 && strlen($customerSearch) >= 2)
                            <div class="mt-2 text-sm text-gray-500">
                                No customers found. <span class="text-orange-600 font-medium">A new customer will be
                                    created with provided details.</span>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                            <input type="text" wire:model.live="customerName"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Enter customer name" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Phone</label>
                            <input type="tel" wire:model.live="customerPhone"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Enter phone number" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea wire:model.live="notes" rows="3"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Any additional notes..."></textarea>
                        </div>
                    </div>

                    @if ($customerId)
                        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center text-green-700 text-sm">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Existing customer selected. Loyalty points will be awarded.</span>
                            </div>
                        </div>
                    @endif
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
                            <span class="font-medium text-gray-900" id="sub-total">
                                ৳{{ number_format($subTotal, 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Discount</span>
                            <div class="flex items-center gap-2">
                                <input type="number" wire:model.live="discount" wire:change="calculateTotals"
                                    class="w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-orange-500"
                                    min="0" step="0.01" />
                                <span class="text-sm text-gray-500">৳</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Tax Rate</span>
                            <div class="flex items-center gap-2">
                                <input type="number" wire:model.live="taxRate" wire:change="calculateTotals"
                                    class="w-16 px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-orange-500"
                                    min="0" max="100" step="0.1" />
                                <span class="text-sm text-gray-500">%</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Tax Amount</span>
                            <span class="font-medium text-gray-900" id="tax-amount">
                                ৳{{ number_format($taxAmount, 2) }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Grand Total</span>
                                <span class="text-xl font-bold text-orange-600" id="grand-total">
                                    ৳{{ number_format($grandTotal, 2) }}
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
                            <div class="grid grid-cols-2 gap-2">
                                @foreach (['cash', 'card', 'mobile_banking', 'other'] as $method)
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" wire:model="paymentMethod" value="{{ $method }}"
                                            class="mr-2 text-orange-600 focus:ring-orange-500" />
                                        <span class="text-sm capitalize">{{ str_replace('_', ' ', $method) }}</span>
                                    </label>
                                @endforeach
                            </div>
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
                        <button type="button" wire:click="saveDraft"
                            class="w-full bg-gray-100 text-gray-700 hover:bg-gray-200 py-3 rounded-lg text-sm font-medium transition-colors">
                            Save as Draft
                        </button>
                        <button type="button" wire:click="createSale"
                            {{ count($medicineItems) === 0 ? 'disabled' : '' }}
                            class="w-full bg-orange-500 text-white hover:bg-orange-600 py-3 rounded-lg text-sm font-medium transition-colors {{ count($medicineItems) === 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                            Complete Sale
                        </button>
                        <button type="button" wire:click="resetForm"
                            class="w-full bg-red-500 text-white hover:bg-red-600 py-3 rounded-lg text-sm font-medium transition-colors">
                            Reset Form
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
