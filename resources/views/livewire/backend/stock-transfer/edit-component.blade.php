<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Stock Transfer</h1>
                    <p class="text-sm text-gray-600 mt-1">Transfer #{{ $transfer_number }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a wire:navigate href="{{ route('admin.stock-transfers.view', $transfer_id) }}"
                        class="bg-white text-gray-700 hover:text-gray-900 border border-gray-300 hover:border-gray-400 px-4 py-2 rounded-lg text-sm transition-colors">
                        View Transfer
                    </a>
                    <a wire:navigate href="{{ route('admin.stock-transfers.index') }}"
                        class="bg-white text-gray-700 hover:text-gray-900 border border-gray-300 hover:border-gray-400 px-4 py-2 rounded-lg text-sm transition-colors">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Transfer Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Transfer Information Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Transfer Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Transfer Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Transfer Number</label>
                            <input type="text" value="{{ $transfer_number }}" readonly
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-500">
                        </div>

                        <!-- Transfer Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Transfer Date *</label>
                            <input type="date" wire:model="transfer_date"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @error('transfer_date')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- From Branch -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">From Branch *</label>
                            <select wire:model.live="from_branch_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('from_branch_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- To Branch -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">To Branch *</label>
                            <select wire:model="to_branch_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('to_branch_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select wire:model="status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="completed">Completed</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea wire:model="notes" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                placeholder="Any additional notes..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Transfer Items Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Transfer Items</h2>
                        <button type="button" wire:click="addItem"
                            class="bg-orange-50 text-orange-600 hover:bg-orange-100 border border-orange-200 px-3 py-1 rounded-lg text-sm font-medium">
                            + Add Item
                        </button>
                    </div>

                    @foreach ($items as $index => $item)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="font-medium text-gray-900">Item #{{ $index + 1 }}</h3>
                                @if ($index > 0 || (count($items) === 1 && empty($item['medicine_id'])))
                                    <button type="button" wire:click="removeItem({{ $index }})"
                                        class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Medicine Dropdown -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Medicine *</label>
                                    <select wire:model.live="items.{{ $index }}.medicine_id"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                        <option value="">Select Medicine</option>
                                        @foreach ($medicineOptions as $medicineOption)
                                            <option value="{{ $medicineOption['medicine_id'] }}">
                                                {{ $medicineOption['medicine_name'] }}
                                                ({{ $medicineOption['generic_name'] }})
                                                @if (count($medicineOption['batches']) > 1)
                                                    - {{ count($medicineOption['batches']) }} batches
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($item['medicine_name'])
                                        <div class="mt-2 text-xs text-gray-600">
                                            <div><strong>Batch:</strong> {{ $item['batch_number'] }}</div>
                                            <div><strong>Expiry:</strong> {{ $item['expiry_date'] }}</div>
                                            <div><strong>Unit Price:</strong>
                                                ৳{{ number_format($item['unit_price'], 2) }}</div>
                                        </div>
                                    @endif

                                    @error('items.' . $index . '.medicine_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Available Quantity -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Available</label>
                                    <div
                                        class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-500">
                                        {{ $item['available_quantity'] }}
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                    <input type="number" wire:model.live="items.{{ $index }}.quantity"
                                        min="1" max="{{ $item['available_quantity'] }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                    @error('items.' . $index . '.quantity')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Unit Price -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price *</label>
                                    <input type="number" wire:model.live="items.{{ $index }}.unit_price"
                                        step="0.01"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                    @error('items.' . $index . '.unit_price')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Total Price -->
                                <div class="md:col-span-2 lg:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                                    <div
                                        class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-500 font-medium">
                                        ৳{{ number_format($item['total_price'], 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Column: Summary & Actions -->
            <div class="space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Transfer Summary</h2>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Items</span>
                            <span class="font-medium">{{ $totalItems }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Quantity</span>
                            <span class="font-medium">
                                {{ array_sum(array_column($items, 'quantity')) }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Grand Total</span>
                            <span class="font-medium text-lg text-orange-600">
                                ৳{{ number_format($grandTotal, 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="update" wire:loading.attr="disabled"
                            class="w-full bg-orange-500 text-white hover:bg-orange-600 px-4 py-3 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Update Transfer
                            <span wire:loading wire:target="update">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </button>

                        <a wire:navigate href="{{ route('admin.stock-transfers.index') }}"
                            class="block w-full text-center mt-3 bg-white text-gray-700 hover:text-gray-900 border border-gray-300 hover:border-gray-400 px-4 py-3 rounded-lg font-medium transition-colors">
                            Cancel
                        </a>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <h3 class="font-medium text-yellow-900 mb-2">Important Notes</h3>
                    <ul class="text-sm text-yellow-800 space-y-2">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle mt-0.5"></i>
                            <span>Changing the source branch will clear all selected medicines</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle mt-0.5"></i>
                            <span>Removing items will restore stock to the source branch</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle mt-0.5"></i>
                            <span>Stock adjustments happen immediately when you update</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-info-circle mt-0.5"></i>
                            <span>Set status to "Completed" only when transfer is physically done</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
