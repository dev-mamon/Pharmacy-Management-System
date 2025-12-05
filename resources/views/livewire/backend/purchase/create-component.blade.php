<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create New Purchase</h1>
                <p class="text-sm text-gray-600 mt-1">
                    Create a new medicine purchase order.
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

        <!-- Create Form Card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <form wire:submit="save" class="p-6">
                <div class="space-y-6">
                    <!-- Purchase Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="purchase_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Purchase Number *
                            </label>
                            <input type="text" id="purchase_number" wire:model="purchase_number" readonly
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-gray-50">
                            @error('purchase_number')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Supplier *
                            </label>
                            <select id="supplier_id" wire:model="supplier_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Branch *
                            </label>
                            <select id="branch_id" wire:model="branch_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Purchase Date *
                            </label>
                            <input type="date" id="purchase_date" wire:model="purchase_date"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @error('purchase_date')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Purchase By *
                            </label>
                            <select id="user_id" wire:model="user_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="searchMedicine" class="block text-sm font-medium text-gray-700 mb-2">
                                Search Medicine
                            </label>
                            <input type="text" id="searchMedicine" wire:model.live="searchMedicine"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                placeholder="Search by name or generic name">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes
                        </label>
                        <textarea id="notes" wire:model="notes" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                            placeholder="Enter any additional notes"></textarea>
                        @error('notes')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Purchase Items Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Purchase Items</h3>
                            <button type="button" wire:click="addItem"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Item
                            </button>
                        </div>

                        <!-- Items Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Medicine</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Batch No</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Unit Price</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Price</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Expiry Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($items as $index => $item)
                                        <tr class="align-top">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <select wire:model="items.{{ $index }}.medicine_id"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('items.' . $index . '.medicine_id') border-red-500 @enderror">
                                                    <option value="">Select Medicine</option>
                                                    @foreach ($filteredMedicines as $medicine)
                                                        <option value="{{ $medicine->id }}">
                                                            {{ $medicine->name }} ({{ $medicine->generic_name }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('items.' . $index . '.medicine_id')
                                                    <div class="mt-1">
                                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="text"
                                                    wire:model="items.{{ $index }}.batch_number"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('items.' . $index . '.batch_number') border-red-500 @enderror">
                                                @error('items.' . $index . '.batch_number')
                                                    <div class="mt-1">
                                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="number" min="1"
                                                    wire:model.live="items.{{ $index }}.quantity"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('items.' . $index . '.quantity') border-red-500 @enderror">
                                                @error('items.' . $index . '.quantity')
                                                    <div class="mt-1">
                                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="number" step="0.01" min="0"
                                                    wire:model.live="items.{{ $index }}.unit_price"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('items.' . $index . '.unit_price') border-red-500 @enderror">
                                                @error('items.' . $index . '.unit_price')
                                                    <div class="mt-1">
                                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="text" readonly
                                                    value="{{ number_format($item['total_price'] ?? 0, 2) }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="date"
                                                    wire:model="items.{{ $index }}.expiry_date"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('items.' . $index . '.expiry_date') border-red-500 @enderror">
                                                @error('items.' . $index . '.expiry_date')
                                                    <div class="mt-1">
                                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if ($loop->index > 0)
                                                    <button type="button"
                                                        wire:click="removeItem({{ $index }})"
                                                        class="text-red-600 hover:text-red-900">
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
                    </div>

                    <!-- Totals Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="discount" class="block text-sm font-medium text-gray-700 mb-2">
                                            Discount (৳)
                                        </label>
                                        <input type="number" step="0.01" min="0" id="discount"
                                            wire:model.live="discount"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                        @error('discount')
                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                            Tax Rate (%)
                                        </label>
                                        <input type="number" step="0.01" min="0" max="100"
                                            id="tax_rate" wire:model.live="tax_rate"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                        @error('tax_rate')
                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Subtotal:</span>
                                    <span class="font-medium">৳{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Discount:</span>
                                    <span
                                        class="font-medium text-green-600">-৳{{ number_format($discount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Tax Amount ({{ $tax_rate }}%):</span>
                                    <span class="font-medium">৳{{ number_format($tax_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                    <span class="text-lg font-semibold text-gray-900">Grand Total:</span>
                                    <span
                                        class="text-xl font-bold text-orange-600">৳{{ number_format($grand_total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                    <a wire:navigate href="{{ route('admin.purchases.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-orange-500 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Create Purchase
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
