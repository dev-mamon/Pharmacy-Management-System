<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Stock Transfer Details
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    View and manage stock transfer information
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

        <!-- Transfer Information Card -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <!-- Card Header with Status -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Transfer #{{ $transfer->transfer_number }}</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Created on {{ $transfer->created_at->format('M d, Y \a\t h:i A') }} by
                            {{ $transfer->user->name }}
                        </p>
                    </div>

                    <!-- Status Badge -->
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            'approved' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'rejected' => 'bg-red-50 text-red-700 border-red-200',
                            'completed' => 'bg-green-50 text-green-700 border-green-200',
                        ];
                    @endphp
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 text-sm rounded border {{ $statusColors[$transfer->status] }}">
                        @if ($transfer->status === 'pending')
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                        @elseif($transfer->status === 'approved')
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        @elseif($transfer->status === 'rejected')
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        @endif
                        {{ ucfirst($transfer->status) }}
                    </span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Transfer Details -->
                    <div class="space-y-4">
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Transfer Details</h3>

                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="w-32 text-sm font-medium text-gray-500">From Branch:</div>
                                <div class="text-sm text-gray-900">{{ $transfer->fromBranch->name }}</div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-32 text-sm font-medium text-gray-500">To Branch:</div>
                                <div class="text-sm text-gray-900">{{ $transfer->toBranch->name }}</div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-32 text-sm font-medium text-gray-500">Transfer Date:</div>
                                <div class="text-sm text-gray-900">{{ $transfer->transfer_date->format('M d, Y') }}
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-32 text-sm font-medium text-gray-500">Total Items:</div>
                                <div class="text-sm text-gray-900">{{ $transfer->items->count() }} items</div>
                            </div>

                            @if ($transfer->notes)
                                <div class="flex items-start">
                                    <div class="w-32 text-sm font-medium text-gray-500">Notes:</div>
                                    <div class="text-sm text-gray-900">{{ $transfer->notes }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Actions</h3>

                        <div class="space-y-2">
                            @if ($transfer->status === 'pending')
                                <div class="flex gap-2">
                                    <button wire:click="approve"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        <i class="fas fa-check mr-2"></i>
                                        Approve
                                    </button>

                                    <button wire:click="reject"
                                        wire:confirm="Are you sure you want to reject this transfer?"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        <i class="fas fa-times mr-2"></i>
                                        Reject
                                    </button>
                                </div>

                                <div class="flex gap-2">
                                    <a wire:navigate href="{{ route('stock-transfers.edit', $transfer->id) }}"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                        <i class="fas fa-edit mr-2"></i>
                                        Edit
                                    </a>

                                    <button wire:click="delete"
                                        wire:confirm="Are you sure you want to delete this transfer?"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        <i class="fas fa-trash mr-2"></i>
                                        Delete
                                    </button>
                                </div>
                            @endif

                            @if ($transfer->status === 'approved')
                                <button wire:click="complete"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    <i class="fas fa-truck mr-2"></i>
                                    Complete Transfer
                                </button>
                            @endif

                            @if ($transfer->status === 'completed')
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <div>
                                            <p class="text-sm font-medium text-green-800">Transfer Completed</p>
                                            <p class="text-xs text-green-600 mt-1">
                                                All items have been transferred successfully.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Items List -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Transfer Items</h3>

                    @if ($transfer->items->count() > 0)
                        <div class="overflow-x-auto no-scrollbar scroll-hint">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Medicine</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Batch</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Expiry</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($transfer->items as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">
                                                {{ $item->stock->medicine->name }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                <code
                                                    class="bg-gray-100 px-2 py-0.5 rounded">{{ $item->stock->batch_number }}</code>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($item->stock->expiry_date)->format('M d, Y') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 font-semibold">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                {{ $item->notes ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="far fa-box-open text-4xl text-gray-400 mb-3"></i>
                            <p class="text-lg font-medium text-gray-900">No items in this transfer</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
