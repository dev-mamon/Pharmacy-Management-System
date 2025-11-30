<?php

namespace App\Livewire\Backend\Dashboard;

use Livewire\Component;

class IndexComponent extends Component
{
    public $dateRange = '30days';
    public $selectedBranch = 'all';
    public $chartType = 'revenue';

    // Static data arrays
    private $salesStats = [
        'total_sales' => 125400.50,
        'total_transactions' => 342,
        'average_transaction' => 366.67,
        'growth_rate' => 12.5,
    ];

    private $purchaseStats = [
        'total_purchases' => 78450.25,
        'total_orders' => 67,
    ];

    private $expenseStats = [
        'total_expenses' => 23450.75,
        'expense_by_type' => [
            ['expense_type' => 'Salaries', 'total' => 15000],
            ['expense_type' => 'Utilities', 'total' => 4500],
            ['expense_type' => 'Rent', 'total' => 3000],
            ['expense_type' => 'Supplies', 'total' => 950.75],
        ],
    ];

    private $stockStats = [
        'low_stock' => 8,
        'out_of_stock' => 3,
        'total_stock_value' => 187650.80,
    ];

    private $revenueChartData = [
        ['date' => 'Jan 1', 'sales' => 4200, 'purchases' => 2800, 'expenses' => 1200, 'profit' => 200],
        ['date' => 'Jan 2', 'sales' => 3800, 'purchases' => 2500, 'expenses' => 1100, 'profit' => 200],
        ['date' => 'Jan 3', 'sales' => 5200, 'purchases' => 3200, 'expenses' => 1300, 'profit' => 700],
        ['date' => 'Jan 4', 'sales' => 4800, 'purchases' => 2900, 'expenses' => 1250, 'profit' => 650],
        ['date' => 'Jan 5', 'sales' => 6100, 'purchases' => 3800, 'expenses' => 1400, 'profit' => 900],
        ['date' => 'Jan 6', 'sales' => 5500, 'purchases' => 3400, 'expenses' => 1350, 'profit' => 750],
        ['date' => 'Jan 7', 'sales' => 4900, 'purchases' => 3100, 'expenses' => 1280, 'profit' => 520],
    ];

    private $paymentMethodData = [
        ['method' => 'Cash', 'count' => 156, 'total' => 45200.50],
        ['method' => 'Card', 'count' => 128, 'total' => 61200.75],
        ['method' => 'Mobile Banking', 'count' => 45, 'total' => 15800.25],
        ['method' => 'Other', 'count' => 13, 'total' => 3199.00],
    ];

    private $topSellingMedicines = [
        ['name' => 'Paracetamol 500mg', 'sales' => 856, 'revenue' => 4280.00],
        ['name' => 'Amoxicillin 250mg', 'sales' => 623, 'revenue' => 5607.00],
        ['name' => 'Vitamin C 1000mg', 'sales' => 512, 'revenue' => 3072.00],
        ['name' => 'Ibuprofen 400mg', 'sales' => 487, 'revenue' => 3409.00],
        ['name' => 'Cetirizine 10mg', 'sales' => 421, 'revenue' => 2105.00],
    ];

    private $recentActivity = [
        [
            'type' => 'sale',
            'title' => 'New Sale',
            'description' => 'Invoice: INV-2024-00123',
            'amount' => 1245.50,
            'user' => 'Dr. Smith',
            'time' => '2 hours ago',
            'icon' => 'fas fa-shopping-cart text-green-500',
            'color' => 'text-green-700 bg-green-50 border-green-200',
        ],
        [
            'type' => 'purchase',
            'title' => 'New Purchase',
            'description' => 'Order from PharmaCorp',
            'amount' => 8450.75,
            'user' => 'John Doe',
            'time' => '4 hours ago',
            'icon' => 'fas fa-truck text-blue-500',
            'color' => 'text-blue-700 bg-blue-50 border-blue-200',
        ],
        [
            'type' => 'sale',
            'title' => 'New Sale',
            'description' => 'Invoice: INV-2024-00124',
            'amount' => 567.25,
            'user' => 'Dr. Johnson',
            'time' => '5 hours ago',
            'icon' => 'fas fa-shopping-cart text-green-500',
            'color' => 'text-green-700 bg-green-50 border-green-200',
        ],
        [
            'type' => 'expense',
            'title' => 'Utility Bill',
            'description' => 'Monthly electricity bill',
            'amount' => 1250.00,
            'user' => 'Admin',
            'time' => '1 day ago',
            'icon' => 'fas fa-bolt text-yellow-500',
            'color' => 'text-yellow-700 bg-yellow-50 border-yellow-200',
        ],
        [
            'type' => 'sale',
            'title' => 'New Sale',
            'description' => 'Invoice: INV-2024-00125',
            'amount' => 2340.80,
            'user' => 'Dr. Wilson',
            'time' => '1 day ago',
            'icon' => 'fas fa-shopping-cart text-green-500',
            'color' => 'text-green-700 bg-green-50 border-green-200',
        ],
    ];

    private $stockAlerts = [
        [
            'name' => 'Aspirin 75mg',
            'current_stock' => 5,
            'min_stock' => 20,
            'status' => 'low',
            'urgency' => 'high'
        ],
        [
            'name' => 'Insulin Syringes',
            'current_stock' => 0,
            'min_stock' => 50,
            'status' => 'out',
            'urgency' => 'critical'
        ],
        [
            'name' => 'Bandages 10cm',
            'current_stock' => 8,
            'min_stock' => 25,
            'status' => 'low',
            'urgency' => 'medium'
        ],
        [
            'name' => 'Antiseptic Solution',
            'current_stock' => 0,
            'min_stock' => 15,
            'status' => 'out',
            'urgency' => 'critical'
        ],
    ];

    public function updatedDateRange()
    {
        // Simulate data change
        $this->dispatch('refresh-charts');
    }

    public function updatedSelectedBranch()
    {
        // Simulate data change
        $this->dispatch('refresh-charts');
    }

    public function updatedChartType()
    {
        // Simulate data change
        $this->dispatch('refresh-charts');
    }

    public function render()
    {
        return view('livewire.backend.dashboard.index-component', [
            'salesStats' => $this->salesStats,
            'purchaseStats' => $this->purchaseStats,
            'expenseStats' => $this->expenseStats,
            'stockStats' => $this->stockStats,
            'revenueChartData' => $this->revenueChartData,
            'paymentMethodData' => $this->paymentMethodData,
            'topSellingMedicines' => $this->topSellingMedicines,
            'recentActivity' => $this->recentActivity,
            'stockAlerts' => $this->stockAlerts,
            'dateRanges' => [
                '7days' => 'Last 7 Days',
                '30days' => 'Last 30 Days',
                '90days' => 'Last 90 Days',
                '1year' => 'Last Year',
            ],
            'chartTypes' => [
                'revenue' => 'Revenue',
                'sales' => 'Sales',
                'profit' => 'Profit',
            ],
            'branches' => [
                'all' => 'All Branches',
                '1' => 'Main Branch',
                '2' => 'Downtown Branch',
                '3' => 'Northside Branch',
            ],
        ])->layout('layouts.backend.app');
    }
}
