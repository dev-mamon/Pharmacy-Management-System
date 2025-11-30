<main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100 no-scrollbar">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Pharmacy Dashboard
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    Overview of your pharmacy performance and statistics
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <!-- Date Range Filter -->
                <div class="relative">
                    <select wire:model="dateRange"
                        class="h-10 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                        @foreach ($dateRanges as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <!-- Branch Filter -->
                <div class="relative">
                    <select wire:model="selectedBranch"
                        class="h-10 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                        @foreach ($branches as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <!-- Chart Type Filter -->
                <div class="relative">
                    <select wire:model="chartType"
                        class="h-10 pl-3 pr-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 appearance-none">
                        @foreach ($chartTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Sales -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Sales</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            ${{ number_format($salesStats['total_sales'], 2) }}</p>
                        <p
                            class="text-xs {{ $salesStats['growth_rate'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                            <i class="fas fa-arrow-{{ $salesStats['growth_rate'] >= 0 ? 'up' : 'down' }} mr-1"></i>
                            {{ number_format(abs($salesStats['growth_rate']), 1) }}% from previous period
                        </p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Transactions</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ number_format($salesStats['total_transactions']) }}</p>
                        <p class="text-xs text-blue-600 mt-1">
                            <i class="fas fa-receipt mr-1"></i>
                            ${{ number_format($salesStats['average_transaction'], 2) }} average
                        </p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Purchases -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Purchases</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            ${{ number_format($purchaseStats['total_purchases'], 2) }}</p>
                        <p class="text-xs text-purple-600 mt-1">
                            <i class="fas fa-truck mr-1"></i>
                            {{ number_format($purchaseStats['total_orders']) }} orders
                        </p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-lg">
                        <i class="fas fa-boxes text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Stock Status -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Stock Alerts</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ number_format($stockStats['low_stock'] + $stockStats['out_of_stock']) }}</p>
                        <p class="text-xs text-red-600 mt-1">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $stockStats['low_stock'] }} low, {{ $stockStats['out_of_stock'] }} out
                        </p>
                    </div>
                    <div class="p-3 bg-red-50 rounded-lg">
                        <i class="fas fa-cubes text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Graphs Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Revenue Chart -->
            <div class="lg:col-span-2 bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Revenue Overview</h3>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span>Sales</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span>Purchases</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span>Expenses</span>
                        </div>
                    </div>
                </div>
                <div class="h-80">
                    <!-- Simple Bar Chart using CSS -->
                    <div class="flex items-end justify-between h-64 gap-1 mt-4">
                        @foreach ($revenueChartData as $data)
                            <div class="flex flex-col items-center flex-1">
                                <div class="flex items-end justify-center gap-1 w-full h-48">
                                    <div class="w-1/3 bg-green-500 rounded-t"
                                        style="height: {{ ($data['sales'] / 7000) * 100 }}%"
                                        title="Sales: ${{ number_format($data['sales']) }}"></div>
                                    <div class="w-1/3 bg-blue-500 rounded-t"
                                        style="height: {{ ($data['purchases'] / 4000) * 100 }}%"
                                        title="Purchases: ${{ number_format($data['purchases']) }}"></div>
                                    <div class="w-1/3 bg-red-500 rounded-t"
                                        style="height: {{ ($data['expenses'] / 1500) * 100 }}%"
                                        title="Expenses: ${{ number_format($data['expenses']) }}"></div>
                                </div>
                                <span class="text-xs text-gray-600 mt-2">{{ $data['date'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Payment Methods Pie Chart -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Payment Methods</h3>
                <div class="h-64 flex items-center justify-center">
                    <!-- Simple Pie Chart using CSS -->
                    <div class="relative w-40 h-40 rounded-full"
                        style="background: conic-gradient(
                             #10B981 0deg 126deg,
                             #3B82F6 126deg 252deg,
                             #8B5CF6 252deg 324deg,
                             #F59E0B 324deg 360deg
                         )">
                    </div>
                </div>
                <div class="mt-6 space-y-3">
                    @foreach ($paymentMethodData as $index => $method)
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                @php
                                    $colors = ['#10B981', '#3B82F6', '#8B5CF6', '#F59E0B'];
                                @endphp
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $colors[$index] }}">
                                </div>
                                <span class="text-gray-700">{{ $method['method'] }}</span>
                            </div>
                            <div class="text-right">
                                <span
                                    class="font-semibold text-gray-900">${{ number_format($method['total'], 2) }}</span>
                                <span class="text-xs text-gray-500 block">{{ $method['count'] }} transactions</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Activity -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Activity</h3>
                <div class="space-y-4">
                    @foreach ($recentActivity as $activity)
                        <div class="flex items-start gap-4 p-3 rounded-lg border {{ $activity['color'] }}">
                            <div class="p-2 rounded-lg bg-white border border-gray-200">
                                <i class="{{ $activity['icon'] }} text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                    <p class="text-sm font-semibold text-gray-900">
                                        ${{ number_format($activity['amount'], 2) }}</p>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $activity['description'] }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-gray-500">By {{ $activity['user'] }}</span>
                                    <span class="text-xs text-gray-500">{{ $activity['time'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Stock Alerts & Top Products -->
            <div class="space-y-6">
                <!-- Stock Alerts -->
                <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Stock Alerts</h3>
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                            {{ count($stockAlerts) }} Critical
                        </span>
                    </div>
                    <div class="space-y-3">
                        @foreach ($stockAlerts as $alert)
                            <div
                                class="flex items-center justify-between p-3 rounded-lg border
                                {{ $alert['status'] == 'out' ? 'bg-red-50 border-red-200' : 'bg-yellow-50 border-yellow-200' }}">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="p-2 rounded-lg {{ $alert['status'] == 'out' ? 'bg-red-100' : 'bg-yellow-100' }}">
                                        <i
                                            class="{{ $alert['status'] == 'out' ? 'fas fa-times-circle text-red-600' : 'fas fa-exclamation-triangle text-yellow-600' }}"></i>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-medium {{ $alert['status'] == 'out' ? 'text-red-800' : 'text-yellow-800' }}">
                                            {{ $alert['name'] }}
                                        </p>
                                        <p
                                            class="text-xs {{ $alert['status'] == 'out' ? 'text-red-600' : 'text-yellow-600' }}">
                                            Stock: {{ $alert['current_stock'] }} | Min: {{ $alert['min_stock'] }}
                                        </p>
                                    </div>
                                </div>
                                <span
                                    class="px-2 py-1 text-xs font-medium
                                    {{ $alert['status'] == 'out' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full">
                                    {{ $alert['status'] == 'out' ? 'Out of Stock' : 'Low Stock' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Top Selling Medicines -->
                <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Top Selling Medicines</h3>
                    <div class="space-y-4">
                        @foreach ($topSellingMedicines as $medicine)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-lg bg-blue-50">
                                        <i class="fas fa-pills text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $medicine['name'] }}</p>
                                        <p class="text-xs text-gray-600">{{ number_format($medicine['sales']) }} units
                                            sold</p>
                                    </div>
                                </div>
                                <span
                                    class="text-sm font-semibold text-gray-900">${{ number_format($medicine['revenue'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Expense Breakdown -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Expense Breakdown</h3>
                <div class="space-y-4">
                    @foreach ($expenseStats['expense_by_type'] as $expense)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">{{ $expense['expense_type'] }}</span>
                            <span
                                class="text-sm font-semibold text-gray-900">${{ number_format($expense['total'], 2) }}</span>
                        </div>
                    @endforeach
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-900">Total Expenses</span>
                            <span
                                class="text-sm font-bold text-red-600">${{ number_format($expenseStats['total_expenses'], 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Value -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Inventory Value</h3>
                    <div class="p-2 rounded-lg bg-green-100">
                        <i class="fas fa-warehouse text-green-600"></i>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-gray-900">
                        ${{ number_format($stockStats['total_stock_value'], 2) }}</p>
                    <p class="text-sm text-gray-600 mt-2">Total inventory value across all branches</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
                <div class="space-y-3">
                    <button
                        class="w-full flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="p-2 rounded-lg bg-blue-50">
                            <i class="fas fa-plus text-blue-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">New Sale</span>
                    </button>
                    <button
                        class="w-full flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="p-2 rounded-lg bg-green-50">
                            <i class="fas fa-truck text-green-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">New Purchase</span>
                    </button>
                    <button
                        class="w-full flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="p-2 rounded-lg bg-orange-50">
                            <i class="fas fa-cubes text-orange-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Manage Stock</span>
                    </button>
                    <button
                        class="w-full flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="p-2 rounded-lg bg-purple-50">
                            <i class="fas fa-chart-bar text-purple-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">View Reports</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
