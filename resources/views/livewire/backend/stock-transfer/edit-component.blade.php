<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $isEditing ? 'Edit Stock Transfer' : 'Create New Stock Transfer' }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $isEditing ? 'Update stock transfer details' : 'Transfer inventory between branches' }}
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <a wire:navigate href="{{ route('stock-transfers.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Transfer Form Card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Transfer Information</h2>
                <p class="text-sm text-gray-600 mt-1">Fill in the details for the stock transfer.</p>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <form wire:submit.prevent="save">
                    <div class="space-y-6">
                        <!-- Transfer Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- From Branch -->
                            <div>
                                <label for="from_branch_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    From Branch <span class="text-red-500">*</span>
                                </label>
                                <select id="from_branch_id" wire:model.live="from_branch_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                                    {{ $isEditing ? 'disabled' : '' }}>
                                    <option value="">Select branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('from_branch_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- To Branch -->
                            <div>
                                <label for="to_branch_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    To Branch <span class="text-red-500">*</span>
                                </label>
                                <select id="to_branch_id" wire:model="to_branch_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                                    <option value="">Select branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('to_branch_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Transfer Date -->
                            <div>
                                <label for="transfer_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    Transfer Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="transfer_date" wire:model="transfer_date"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                                @error('transfer_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Transfer Number -->
                            @if ($isEditing && $transfer_number)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Transfer Number
                                    </label>
                                    <div class="w-full px-3 py-2 border border-gray-300 bg-gray-50 rounded-md">
                                        <code class="text-sm font-mono">{{ $transfer_number }}</code>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Notes
                            </label>
                            <textarea id="notes" wire:model="notes" rows="3" placeholder="Add any notes about this transfer..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"></textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Add Items Section -->
                        <div class="border-t pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Transfer Items</h3>
                                <div class="text-sm text-gray-600">
                                    Total Items: <span class="font-bold">{{ count($items) }}</span>
                                </div>
                            </div>

                            @if ($from_branch_id)
                                <!-- Add Item Form -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                    <h4 class="text-sm font-medium text-gray-800 mb-3">Add New Item</h4>

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <!-- Select Medicine -->
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                                Select Medicine
                                            </label>
                                            <select wire:model="selectedStock"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm">
                                                <option value="">Select medicine</option>
                                                @foreach ($availableStocks as $stock)
                                                    <option value="{{ $stock->id }}">
                                                        {{ $stock->medicine->name }}
                                                        (Batch: {{ $stock->batch_number }}, Available:
                                                        {{ $stock->quantity }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Quantity -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                                Quantity
                                            </label>
                                            <input type="number" wire:model="selectedQuantity" min="1"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm">
                                        </div>

                                        <!-- Add Button -->
                                        <div class="flex items-end">
                                            <button type="button" wire:click="addItem"
                                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                                <i class="fas fa-plus mr-2"></i>
                                                Add Item
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Item Notes -->
                                    <div class="mt-3">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">
                                            Item Notes (Optional)
                                        </label>
                                        <input type="text" wire:model="itemNotes"
                                            placeholder="Enter notes for this item..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm">
                                    </div>
                                </div>
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                                    <p class="text-yellow-700">Please select a "From Branch" to view available medicines
                                    </p>
                                </div>
                            @endif

                            <!-- Items List -->
                            @if (count($items) > 0)
                                <div class="space-y-3">
                                    @foreach ($items as $index => $item)
                                        <div
                                            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                            <div class="flex-1">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <h4 class="font-medium text-gray-900">
                                                            {{ $item['stock']['medicine']['name'] }}</h4>
                                                        <div
                                                            class="flex flex-wrap items-center gap-4 mt-1 text-sm text-gray-600">
                                                            <span>Batch: <code
                                                                    class="bg-gray-100 px-2 py-0.5 rounded">{{ $item['stock']['batch_number'] }}</code></span>
                                                            <span>Available: <span
                                                                    class="font-semibold">{{ $item['stock']['quantity'] }}</span></span>
                                                            <span>Transfer: <span
                                                                    class="font-bold text-orange-600">{{ $item['quantity'] }}</span></span>
                                                            <span>Expiry:
                                                                {{ \Carbon\Carbon::parse($item['stock']['expiry_date'])->format('M d, Y') }}</span>
                                                        </div>
                                                        @if ($item['notes'])
                                                            <p class="mt-2 text-sm text-gray-500">
                                                                <i class="far fa-sticky-note mr-1"></i>
                                                                {{ $item['notes'] }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <button type="button"
                                                        wire:click="removeItem({{ $index }})"
                                                        class="ml-4 p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-md">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <i class="far fa-box-open text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-lg font-medium text-gray-900">No items added</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $from_branch_id ? 'Add items to this transfer' : 'Select a "From Branch" to add items' }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Error for empty items -->
                        @error('items')
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                        <a wire:navigate href="{{ route('stock-transfers.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                            Cancel
                        </a>
                        <button type="submit" {{ count($items) === 0 ? 'disabled' : '' }}
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-check mr-2"></i>
                            {{ $isEditing ? 'Update Transfer' : 'Create Transfer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
