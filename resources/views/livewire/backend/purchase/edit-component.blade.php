<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Edit Purchase
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Update medicine information
                </p>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <a wire:navigate href="{{ route('admin.purchases.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('success'))
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Edit Form Card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <!-- Card Body -->
            <div class="p-6">
                <form wire:submit="update" class="space-y-6">
                    <!-- Basic Information Card -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Purchase Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Purchase Number
                                </label>
                                <input type="text" value="{{ $purchase_number }}" readonly
                                    class="w-full h-10 px-3 text-sm rounded-lg border border-gray-300 bg-gray-50 text-gray-500">
                            </div>

                            <!-- Supplier -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Supplier <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="supplier_id"
                                    class="w-full h-10 px-3 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Branch -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Branch <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="branch_id"
                                    class="w-full h-10 px-3 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Purchase Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Purchase Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" wire:model="purchase_date"
                                    class="w-full h-10 px-3 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                @error('purchase_date')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="status"
                                    class="w-full h-10 px-3 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                @error('status')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Notes
                            </label>
                            <textarea wire:model="notes" rows="3"
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Add any notes about this purchase..."></textarea>
                            @error('notes')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Purchase Items Card -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Purchase Items</h2>
                            <button type="button" wire:click="addItem"
                                class="bg-orange-500 text-white hover:bg-orange-600 px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Item
                            </button>
                        </div>

                        <!-- Medicine Search -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Search Medicine
                            </label>
                            <div class="relative">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                <input type="search" wire:model.live="searchMedicine"
                                    class="w-full h-10 pl-10 pr-3 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    placeholder="Search medicines by name or generic name...">
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr class="text-xs font-semibold text-gray-600 uppercase">
                                        <th class="px-4 py-3 text-left">Medicine</th>
                                        <th class="px-4 py-3 text-left">Batch No</th>
                                        <th class="px-4 py-3 text-left">Quantity</th>
                                        <th class="px-4 py-3 text-left">Unit Price (৳)</th>
                                        <th class="px-4 py-3 text-left">Expiry Date</th>
                                        <th class="px-4 py-3 text-left">Total (৳)</th>
                                        <th class="px-4 py-3 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($items as $index => $item)
                                        <tr>
                                            <!-- Medicine -->
                                            <td class="px-4 py-3">
                                                <select wire:model="items.{{ $index }}.medicine_id"
                                                    class="w-full h-9 px-2 text-sm rounded border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500">
                                                    <option value="">Select Medicine</option>
                                                    @foreach ($filteredMedicines as $medicine)
                                                        <option value="{{ $medicine->id }}">
                                                            {{ $medicine->name }} ({{ $medicine->generic_name }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error("items.{$index}.medicine_id")
                                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                                @enderror
                                            </td>

                                            <!-- Batch Number -->
                                            <td class="px-4 py-3">
                                                <input type="text"
                                                    wire:model="items.{{ $index }}.batch_number"
                                                    class="w-full h-9 px-2 text-sm rounded border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500">
                                                @error("items.{$index}.batch_number")
                                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                                @enderror
                                            </td>

                                            <!-- Quantity -->
                                            <td class="px-4 py-3">
                                                <input type="number" min="1"
                                                    wire:model="items.{{ $index }}.quantity"
                                                    class="w-24 h-9 px-2 text-sm rounded border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500">
                                                @error("items.{$index}.quantity")
                                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                                @enderror
                                            </td>

                                            <!-- Unit Price -->
                                            <td class="px-4 py-3">
                                                <input type="number" step="0.01" min="0"
                                                    wire:model="items.{{ $index }}.unit_price"
                                                    class="w-32 h-9 px-2 text-sm rounded border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500">
                                                @error("items.{$index}.unit_price")
                                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                                @enderror
                                            </td>

                                            <!-- Expiry Date -->
                                            <td class="px-4 py-3">
                                                <input type="date"
                                                    wire:model="items.{{ $index }}.expiry_date"
                                                    class="w-36 h-9 px-2 text-sm rounded border border-gray-300 focus:outline-none focus:ring-1 focus:ring-orange-500">
                                                @error("items.{$index}.expiry_date")
                                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                                @enderror
                                            </td>

                                            <!-- Total Price -->
                                            <td class="px-4 py-3">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    ৳{{ number_format($item['total_price'], 2) }}
                                                </div>
                                            </td>

                                            <!-- Action -->
                                            <td class="px-4 py-3">
                                                @if (count($items) > 1)
                                                    <button type="button"
                                                        wire:click="removeItem({{ $index }})"
                                                        class="text-red-600 hover:text-red-800 p-1">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @error('items')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Summary Card -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Purchase Summary</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Subtotal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal</label>
                                <div class="text-2xl font-bold text-gray-900">
                                    ৳{{ number_format($subtotal, 2) }}
                                </div>
                            </div>

                            <!-- Discount -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Discount (৳)</label>
                                <input type="number" step="0.01" min="0" wire:model="discount"
                                    class="w-full h-10 px-3 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                @error('discount')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tax Rate -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tax Rate (%)</label>
                                <input type="number" step="0.01" min="0" max="100"
                                    wire:model="tax_rate"
                                    class="w-full h-10 px-3 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                @error('tax_rate')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tax Amount -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tax Amount</label>
                                <div class="text-2xl font-bold text-red-600">
                                    ৳{{ number_format($tax_amount, 2) }}
                                </div>
                            </div>

                            <!-- Grand Total -->
                            <div class="md:col-span-2 lg:col-span-4">
                                <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-orange-700 mb-1">Grand Total</label>
                                    <div class="text-3xl font-bold text-orange-700">
                                        ৳{{ number_format($grand_total, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3">
                        <a wire:navigate href="{{ route('admin.purchases.index') }}"
                            class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-3 text-sm font-medium text-white bg-orange-500 border border-orange-500 rounded-lg hover:bg-orange-600 transition-colors">
                            Update Purchase
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
