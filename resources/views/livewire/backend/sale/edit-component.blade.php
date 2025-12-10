<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Edit Sale #{{ $sale->invoice_number }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Edit sale details and items
                </p>
                <div class="flex items-center gap-2 mt-2">
                    <span
                        class="px-2 py-1 text-xs rounded {{ $sale->status == 'completed' ? 'bg-green-100 text-green-800' : ($sale->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($sale->status) }}
                    </span>
                    <span class="text-sm text-gray-500">| Created: {{ $sale->created_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a wire:navigate href="{{ route('admin.sales.view', $sale->id) }}"
                    class="bg-white text-gray-700 hover:bg-gray-50 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
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

                    <!-- Branch Selection -->
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

                    <!-- Medicine Dropdown -->
                    @if ($showMedicineDropdown && $branchId)
                        <div class="mb-4 relative" x-data="{ open: true }" @click.away="open = false">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search & Select Medicine</label>

                            <!-- Search Input in Dropdown -->
                            <div class="relative mb-2">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" wire:model.live="dropdownSearch" id="dropdown-search-input"
                                    class="w-full pl-10 pr-10 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    placeholder="Type to search medicines..." autofocus @focus="open = true" />
                                <button type="button" wire:click="$set('showMedicineDropdown', false)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-500">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <!-- Medicine List -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                                x-show="open" x-transition>
                                @if ($filteredMedicines->count() > 0)
                                    @foreach ($filteredMedicines as $medicine)
                                        <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
                                            wire:click="selectMedicineFromDropdown({{ $medicine->id }})">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-900">{{ $medicine->name }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $medicine->generic_name }}
                                                        @if ($medicine->category)
                                                            | {{ $medicine->category->name }}
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="text-sm text-gray-600 ml-4">
                                                    <div class="font-medium">Stock: {{ $medicine->current_stock ?? 0 }}
                                                    </div>
                                                    <div class="text-xs">
                                                        ৳{{ number_format($medicine->selling_price, 2) }}</div>
                                                </div>
                                            </div>
                                            @if ($medicine->batch_number)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Batch: {{ $medicine->batch_number }} |
                                                    Expiry:
                                                    {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('d M, Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="px-4 py-6 text-center text-gray-500">
                                        <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p>No medicines found</p>
                                        @if ($dropdownSearch)
                                            <p class="text-sm mt-1">Try a different search term</p>
                                        @else
                                            <p class="text-sm mt-1">No medicines available in this branch</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif(!$showMedicineDropdown && $branchId)
                        <!-- Show button to open medicine dropdown -->
                        <div class="mb-4">
                            <button type="button" wire:click="showMedicineDropdown"
                                class="w-full text-left px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="text-gray-600 font-medium">Click to search and add more medicines</span>
                            </button>
                        </div>
                    @endif

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
                                                {{ $item['medicine_name'] }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $item['generic_name'] ?? '' }}
                                                @if ($item['batch_number'])
                                                    | Batch: {{ $item['batch_number'] }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="text-sm {{ $item['stock_quantity'] < $item['quantity'] ? 'text-red-600' : 'text-gray-600' }}">
                                                {{ $item['stock_quantity'] }}
                                            </span>
                                            @if ($item['stock_quantity'] < $item['quantity'])
                                                <div class="text-xs text-red-500 mt-1">Insufficient stock!</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <button type="button"
                                                    wire:click="updateMedicineItem({{ $index }}, 'quantity', {{ max(1, $item['quantity'] - 1) }})"
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
                                                    max="{{ $item['stock_quantity'] }}"
                                                    class="w-16 px-2 py-1 text-sm text-center border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-orange-500" />
                                                <button type="button"
                                                    wire:click="updateMedicineItem({{ $index }}, 'quantity', {{ $item['quantity'] + 1 }})"
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
                                                {{ number_format($item['quantity'] * $item['unit_price'], 2) }}
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
                                <p class="mb-2">No medicines added.</p>
                                <p class="text-sm">Click "Add Medicine" to select medicines.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Customer Details Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Details</h2>

                    <!-- Customer Search Dropdown -->
                    <div class="mb-4 relative" x-data="{ open: @entangle('showCustomerDropdown').defer }" @click.away="open = false">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Customer</label>

                        <!-- Customer Search Input -->
                        <div class="relative mb-2">
                            <i
                                class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" wire:model.live="customerSearch" id="customer-search-input"
                                class="w-full pl-10 pr-10 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Type to search customers..." @focus="open = true"
                                @keydown.escape="open = false" />

                            @if ($customerSearch || $customerId)
                                <button type="button" wire:click="clearCustomer"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-500">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>

                        <!-- Customer Search Results Dropdown -->
                        @if ($showCustomerDropdown)
                            <div class="absolute z-10 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto mt-1"
                                x-show="open" x-transition>
                                @if ($filteredCustomers->count() > 0)
                                    <!-- Search Results Header -->
                                    <div class="px-4 py-2 bg-gray-50 border-b border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-semibold text-gray-600">Customers Found
                                                ({{ $filteredCustomers->count() }})</span>
                                            <span class="text-xs text-gray-500">Click to select</span>
                                        </div>
                                    </div>

                                    <!-- Customer List -->
                                    @foreach ($filteredCustomers as $customer)
                                        <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
                                            wire:click="selectCustomerFromDropdown({{ $customer->id }})"
                                            @click="open = false">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        <div class="flex items-center gap-2">
                                                            <span class="flex items-center">
                                                                <i class="fas fa-phone-alt text-xs mr-1"></i>
                                                                {{ $customer->phone ?: 'No phone' }}
                                                            </span>
                                                            <span class="flex items-center">
                                                                <i class="fas fa-id-card text-xs mr-1"></i>
                                                                ID: {{ $customer->customer_id }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right ml-4">
                                                    <div class="text-sm font-medium text-green-600">
                                                        ৳{{ number_format($customer->total_spent, 2) }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        Points: {{ $customer->loyalty_points }}
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($customer->email)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <i class="fas fa-envelope text-xs mr-1"></i>
                                                    {{ $customer->email }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <!-- No Results / Create New -->
                                    <div class="px-4 py-6 text-center">
                                        @if ($customerSearch)
                                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-700">No customers found</p>
                                            <p class="text-xs text-gray-500 mt-1">No existing customer matches
                                                "{{ $customerSearch }}"</p>

                                            <!-- Create New Customer Option -->
                                            <div class="mt-4 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                                <p class="text-sm font-medium text-orange-700 mb-2">Create New
                                                    Customer?</p>
                                                <div class="text-left text-sm text-gray-600 mb-3">
                                                    <div>Name: <span class="font-medium">{{ $customerSearch }}</span>
                                                    </div>
                                                    @if ($customerPhone)
                                                        <div class="mt-1">Phone: <span
                                                                class="font-medium">{{ $customerPhone }}</span></div>
                                                    @endif
                                                </div>
                                                <button type="button" wire:click="createNewCustomer"
                                                    @click="open = false"
                                                    class="px-4 py-2 bg-orange-500 text-white text-sm rounded-lg hover:bg-orange-600 transition-colors w-full">
                                                    <i class="fas fa-user-plus mr-2"></i>
                                                    Create New Customer
                                                </button>
                                            </div>
                                        @else
                                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            <p class="text-sm text-gray-600">Start typing to search customers</p>
                                            <p class="text-xs text-gray-500 mt-1">Search by name, phone, email or ID
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Selected Customer Info -->
                        @if ($customerId)
                            <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-green-700">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <div>
                                            <span class="font-medium">Customer Selected</span>
                                            <div class="text-xs text-green-600 mt-1">
                                                {{ $customerName }} | {{ $customerPhone }}
                                                <span
                                                    class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded">
                                                    ID: {{ $customerId }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" wire:click="clearCustomer"
                                        class="text-sm text-red-600 hover:text-red-800">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Customer Details Form -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                            <input type="text" wire:model.live="customerName"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Customer name" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Phone</label>
                            <input type="tel" wire:model.live="customerPhone"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Phone number" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea wire:model.live="notes" rows="3"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500"
                            placeholder="Any additional notes..."></textarea>
                    </div>

                    <!-- Sale Status -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sale Status</label>
                        <div class="flex items-center gap-4">
                            @foreach (['pending' => 'Pending', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" wire:model="saleStatus" value="{{ $value }}"
                                        class="mr-2 text-orange-600 focus:ring-orange-500" />
                                    <span class="text-sm">{{ $label }}</span>
                                </label>
                            @endforeach
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
                            <span class="font-medium text-gray-900">
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
                            <span class="font-medium text-gray-900">
                                ৳{{ number_format($taxAmount, 2) }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Grand Total</span>
                                <span class="text-xl font-bold text-orange-600">
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
                        <button type="button" wire:click="updateSale"
                            {{ count($medicineItems) === 0 ? 'disabled' : '' }}
                            class="w-full bg-orange-500 text-white hover:bg-orange-600 py-3 rounded-lg text-sm font-medium transition-colors {{ count($medicineItems) === 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <i class="fas fa-save mr-2"></i>
                            Update Sale
                        </button>

                        <button type="button" wire:click="resetForm"
                            class="w-full bg-gray-100 text-gray-700 hover:bg-gray-200 py-3 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-undo mr-2"></i>
                            Reset Changes
                        </button>

                        @if ($sale->status != 'cancelled')
                            <button type="button" wire:click="cancelSale"
                                onclick="return confirm('Are you sure you want to cancel this sale? Stock will be restored.')"
                                class="w-full bg-red-500 text-white hover:bg-red-600 py-3 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-ban mr-2"></i>
                                Cancel Sale
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Original Sale Info -->
                <div class="bg-gray-50 rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Original Sale Info</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Invoice Number:</span>
                            <span class="font-medium">{{ $sale->invoice_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created By:</span>
                            <span class="font-medium">{{ $sale->user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created At:</span>
                            <span class="font-medium">{{ $sale->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="font-medium">{{ $sale->updated_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Original Total:</span>
                            <span class="font-medium">৳{{ number_format($sale->grand_total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Profit:</span>
                            <span
                                class="font-medium text-green-600">৳{{ number_format($sale->total_profit, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('focus-dropdown-search', () => {
                    setTimeout(() => {
                        const searchInput = document.getElementById('dropdown-search-input');
                        if (searchInput) {
                            searchInput.focus();
                        }
                    }, 100);
                });

                Livewire.on('focus-customer-search', () => {
                    setTimeout(() => {
                        const searchInput = document.getElementById('customer-search-input');
                        if (searchInput) {
                            searchInput.focus();
                        }
                    }, 100);
                });
            });
        </script>
    @endpush
</main>
