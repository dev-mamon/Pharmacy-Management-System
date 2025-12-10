<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Barcode Details
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    View barcode information and details
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <a wire:navigate href="{{ route('admin.medicine.barcode') }}"
                    class="bg-gray-100 text-gray-700 hover:bg-gray-200 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Back to List</span>
                </a>
                <button wire:click="downloadBarcode"
                    class="bg-green-500 text-white hover:bg-green-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-green-500">
                    <i class="fas fa-download"></i>
                    <span class="hidden sm:inline">Download</span>
                </button>

                <a wire:navigate href="{{ route('admin.medicine.barcode.edit', $barcode->id) }}"
                    class="bg-orange-500 text-white hover:bg-orange-600 active:scale-95 transition-all duration-200 text-sm flex items-center px-3 sm:px-4 py-2 gap-2 rounded border border-orange-500">
                    <i class="fas fa-edit"></i>
                    <span class="hidden sm:inline">Edit</span>
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column: Barcode Information -->
            <div class="space-y-6">
                <!-- Barcode Information Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Barcode Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Barcode Number</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $barcode->barcode }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Barcode Type</p>
                                    <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        {{ $barcode->barcode_type }}
                                    </span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-full border
                                        {{ $barcode->is_active
                                            ? 'bg-green-50 text-green-700 border-green-200'
                                            : 'bg-red-50 text-red-700 border-red-200' }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full
                                            {{ $barcode->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $barcode->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Created Date</p>
                                    <p class="text-sm text-gray-900">
                                        {{ $barcode->created_at->format('d M, Y h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medicine Information Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Medicine Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Medicine Name</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $barcode->medicine->name }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Generic Name</p>
                                    <p class="text-sm text-gray-900">{{ $barcode->medicine->generic_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Medicine ID</p>
                                    <p class="text-sm text-gray-900">{{ $barcode->medicine->id }}</p>
                                </div>
                            </div>
                            @if ($barcode->medicine->strength)
                                <div>
                                    <p class="text-sm text-gray-500">Strength</p>
                                    <p class="text-sm text-gray-900">{{ $barcode->medicine->strength }}</p>
                                </div>
                            @endif
                            @if ($barcode->medicine->manufacturer)
                                <div>
                                    <p class="text-sm text-gray-500">Manufacturer</p>
                                    <p class="text-sm text-gray-900">{{ $barcode->medicine->manufacturer }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Barcode Preview -->
            <div class="space-y-6">
                <!-- Barcode Preview Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Barcode Preview
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="text-center">
                            <!-- Barcode Image -->
                            <div class="mb-6 p-8 bg-gray-500 rounded-lg">
                                <img src="data:image/png;base64,{{ $barcodeImage }}" alt="{{ $barcode->barcode }}"
                                    class="mx-auto max-w-full h-auto">
                            </div>

                            <!-- Barcode Number -->
                            <div class="mb-4">
                                <p class="text-2xl font-mono font-bold text-gray-900">
                                    {{ $barcode->barcode }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Type: {{ $barcode->barcode_type }}
                                </p>
                            </div>

                            <!-- Scan Instructions -->
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <i class="fas fa-info-circle text-blue-500"></i>
                                    <h4 class="text-sm font-medium text-blue-800">Scan Instructions</h4>
                                </div>
                                <ul class="text-xs text-blue-700 space-y-1 text-left">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-500 mt-0.5"></i>
                                        <span>Ensure proper lighting for scanning</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-500 mt-0.5"></i>
                                        <span>Keep barcode clean and undamaged</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-500 mt-0.5"></i>
                                        <span>Position scanner at 30-45 degree angle</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-500 mt-0.5"></i>
                                        <span>Maintain 2-6 inches distance from scanner</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <button wire:click="downloadBarcode"
                                    class="flex items-center justify-center gap-2 bg-green-500 text-white hover:bg-green-600 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                                    <i class="fas fa-download"></i>
                                    Download PNG
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Information Card -->
                <div class="bg-white rounded-lg border border-gray-100 shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            System Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Created At:</span>
                                <span class="text-gray-900">{{ $barcode->created_at->format('d M, Y h:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Updated At:</span>
                                <span class="text-gray-900">{{ $barcode->updated_at->format('d M, Y h:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Database ID:</span>
                                <span class="text-gray-900">{{ $barcode->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
