<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Stock Transfer Details</h1>
                    <p class="text-sm text-gray-600 mt-1">Transfer #{{ $transfer->transfer_number }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a wire:navigate href="{{ route('admin.stock-transfers.edit', $transfer->id) }}"
                        class="bg-orange-500 text-white hover:bg-orange-600 px-4 py-2 rounded-lg text-sm transition-colors">
                        Edit Transfer
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
                <!-- Transfer Overview Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Transfer Overview</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Transfer Number</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $transfer->transfer_number }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Transfer Date</label>
                                <p class="mt-1 text-gray-900">{{ $transfer->transfer_date->format('F d, Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Created By</label>
                                <p class="mt-1 text-gray-900">{{ $transfer->user->name ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Created At</label>
                                <p class="mt-1 text-gray-900">{{ $transfer->created_at->format('F d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Status & Branches -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <div class="mt-1">
                                    @if ($transfer->status === 'pending')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 text-sm font-medium">
                                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                            Pending
                                        </span>
                                    @elseif($transfer->status === 'approved')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-800 border border-blue-200 text-sm font-medium">
                                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                            Approved
                                        </span>
                                    @elseif($transfer->status === 'rejected')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-800 border border-red-200 text-sm font-medium">
                                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                            Rejected
                                        </span>
                                    @elseif($transfer->status === 'completed')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-800 border border-green-200 text-sm font-medium">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            Completed
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">From Branch</label>
                                    <p class="mt-1 text-gray-900 font-medium">{{ $transfer->fromBranch->name ?? 'N/A' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">To Branch</label>
                                    <p class="mt-1 text-gray-900 font-medium">{{ $transfer->toBranch->name ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Status Actions -->
                            @if ($transfer->status !== 'completed')
                                <div class="pt-4">
                                    <label class="block text-sm font-medium text-gray-500 mb-2">Update Status</label>
                                    <div class="flex flex-wrap gap-2">
                                        @if ($transfer->status === 'pending')
                                            <button wire:click="updateStatus('approved')"
                                                class="px-3 py-1.5 bg-blue-500 text-white hover:bg-blue-600 rounded-lg text-sm">
                                                Approve
                                            </button>
                                            <button wire:click="updateStatus('rejected')"
                                                class="px-3 py-1.5 bg-red-500 text-white hover:bg-red-600 rounded-lg text-sm">
                                                Reject
                                            </button>
                                        @endif

                                        @if (in_array($transfer->status, ['approved', 'pending']))
                                            <button wire:click="updateStatus('completed')"
                                                class="px-3 py-1.5 bg-green-500 text-white hover:bg-green-600 rounded-lg text-sm">
                                                Mark as Completed
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Notes -->
                    @if ($transfer->notes)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <label class="block text-sm font-medium text-gray-500 mb-2">Notes</label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-line">{{ $transfer->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Transfer Items Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Transfer Items</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr class="text-sm font-medium text-gray-600 uppercase tracking-wider">
                                    <th class="px-4 py-3 text-left">#</th>
                                    <th class="px-4 py-3 text-left">Medicine</th>
                                    <th class="px-4 py-3 text-left">Quantity</th>
                                    <th class="px-4 py-3 text-left">Unit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($transferItems as $index => $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900">{{ $item->medicine->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->medicine->generic_name }}
                                            </div>
                                            @if ($item->medicine->form)
                                                <div class="text-xs text-gray-400">{{ $item->medicine->form }} |
                                                    {{ $item->medicine->strength }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 font-medium">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $item->medicine->unit ?? 'pcs' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="2" class="px-4 py-3 text-right font-medium text-gray-700">
                                        Total:
                                    </td>
                                    <td class="px-4 py-3 font-bold text-gray-900">
                                        {{ $totalQuantity }}
                                    </td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Actions & Summary -->
            <div class="space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Transfer Summary</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Items</span>
                            <span class="font-medium text-lg">{{ $transferItems->count() }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Quantity</span>
                            <span class="font-medium text-lg">{{ $totalQuantity }}</span>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Last Updated</span>
                                <span
                                    class="text-sm text-gray-900">{{ $transfer->updated_at->format('M d, Y h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        @if ($transfer->status !== 'completed')
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-center gap-2 text-yellow-800">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span class="text-sm font-medium">Action Required</span>
                                </div>
                                <p class="text-sm text-yellow-700 mt-1">
                                    @if ($transfer->status === 'pending')
                                        This transfer is pending approval.
                                    @elseif($transfer->status === 'approved')
                                        This transfer needs to be marked as completed after physical transfer.
                                    @endif
                                </p>
                            </div>
                        @endif

                        <div class="flex flex-col gap-3">
                            <a wire:navigate href="{{ route('admin.stock-transfers.edit', $transfer->id) }}"
                                class="block w-full text-center bg-orange-500 text-white hover:bg-orange-600 px-4 py-3 rounded-lg font-medium transition-colors">
                                Edit Transfer
                            </a>

                            <button wire:click="deleteTransfer"
                                wire:confirm="Are you sure you want to delete this transfer? This will restore stock to the source branch."
                                class="w-full bg-red-500 text-white hover:bg-red-600 px-4 py-3 rounded-lg font-medium transition-colors">
                                Delete Transfer
                            </button>

                            <a wire:navigate href="{{ route('admin.stock-transfers.index') }}"
                                class="block w-full text-center bg-white text-gray-700 hover:text-gray-900 border border-gray-300 hover:border-gray-400 px-4 py-3 rounded-lg font-medium transition-colors">
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Transfer Timeline -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Transfer Timeline</h2>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-1">
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Transfer Created</p>
                                <p class="text-xs text-gray-500">{{ $transfer->created_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>

                        @if ($transfer->status !== 'pending')
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <div
                                        class="w-3 h-3 rounded-full
                                        {{ $transfer->status === 'approved'
                                            ? 'bg-blue-500'
                                            : ($transfer->status === 'rejected'
                                                ? 'bg-red-500'
                                                : 'bg-green-500') }}">
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        Status changed to {{ ucfirst($transfer->status) }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $transfer->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($transfer->status === 'completed')
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Stock Transferred</p>
                                    <p class="text-xs text-gray-500">Stock has been moved to destination branch</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
