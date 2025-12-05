<?php


use App\Livewire\Backend\Dashboard\IndexComponent;
use Illuminate\Support\Facades\Route;
// Main Routes
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Routes Group
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', IndexComponent::class)->name('dashboard');

    // Branch Management complete
    Route::get('/branches', \App\Livewire\Backend\Branch\IndexComponent::class)->name('branches.index');
    Route::get('/branches/create', \App\Livewire\Backend\Branch\CreateComponent::class)->name('branches.create');
    Route::get('/branches/{id}/edit', \App\Livewire\Backend\Branch\EditComponent::class)->name('branches.edit');
    Route::get('/branches/{branch}', \App\Livewire\Backend\Branch\ViewComponent::class)->name('branches.view');

    // Inventory Management
    // Medicines
    Route::get('/medicines', \App\Livewire\Backend\Medicine\IndexComponent::class)->name('medicines.index');
    Route::get('/medicines/create', \App\Livewire\Backend\Medicine\CreateComponent::class)->name('medicines.create');
    Route::get('/medicines/{id}/edit', \App\Livewire\Backend\Medicine\EditComponent::class)->name('medicines.edit');
    Route::get('/medicines/{medicine}', \App\Livewire\Backend\Medicine\ViewComponent::class)->name('medicines.view');

    // Categories  complete
    Route::get('/categories', \App\Livewire\Backend\Category\IndexComponent::class)->name('categories.index');
    Route::get('/categories/create', \App\Livewire\Backend\Category\CreateComponent::class)->name('categories.create');
    Route::get('/categories/{category}/edit', \App\Livewire\Backend\Category\EditComponent::class)->name('categories.edit');

    // Suppliers
    Route::get('/suppliers', \App\Livewire\Backend\Supplier\IndexComponent::class)->name('suppliers.index');
    Route::get('/suppliers/create', \App\Livewire\Backend\Supplier\CreateComponent::class)->name('suppliers.create');
    Route::get('/suppliers/{supplier}/edit', \App\Livewire\Backend\Supplier\EditComponent::class)->name('suppliers.edit');
    Route::get('/suppliers/{supplier}', \App\Livewire\Backend\Supplier\ViewComponent::class)->name('suppliers.view');

    // Stock Management
    Route::get('/stocks', \App\Livewire\Backend\Stock\IndexComponent::class)->name('stocks.index');
    Route::get('/stocks/create', \App\Livewire\Backend\Stock\CreateComponent::class)->name('stocks.create');
    Route::get('/stocks/{stock}/edit', \App\Livewire\Backend\Stock\EditComponent::class)->name('stocks.edit');
    Route::get('/stocks/{stock}', \App\Livewire\Backend\Stock\ViewComponent::class)->name('stocks.view');

    // Purchases
    Route::get('/purchases', \App\Livewire\Backend\Purchase\IndexComponent::class)->name('purchases.index');
    Route::get('/purchases/create', \App\Livewire\Backend\Purchase\CreateComponent::class)->name('purchases.create');
    Route::get('/purchases/{id}/edit', \App\Livewire\Backend\Purchase\EditComponent::class)->name('purchases.edit');
    Route::get('/purchases/{id}', \App\Livewire\Backend\Purchase\ViewComponent::class)->name('purchases.view');

    // Alerts
    Route::get('/low-stock', \App\Livewire\Backend\Alert\LowStockComponent::class)->name('low-stock.index');
    Route::get('/expiry-alerts', \App\Livewire\Backend\Alert\ExpiryAlertComponent::class)->name('expiry-alerts.index');

    // Stock Transfers
    Route::get('/stock-transfers', \App\Livewire\Backend\StockTransfer\IndexComponent::class)->name('stock-transfers.index');
    Route::get('/stock-transfers/create', \App\Livewire\Backend\StockTransfer\CreateComponent::class)->name('stock-transfers.create');
    Route::get('/stock-transfers/{stockTransfer}/edit', \App\Livewire\Backend\StockTransfer\EditComponent::class)->name('stock-transfers.edit');
    Route::get('/stock-transfers/{stockTransfer}', \App\Livewire\Backend\StockTransfer\ViewComponent::class)->name('stock-transfers.view');

    // Sales & POS
    // POS System
    Route::get('/pos', \App\Livewire\Backend\Pos\IndexComponent::class)->name('pos.index');
    Route::get('/pos/cart', \App\Livewire\Backend\Pos\CartComponent::class)->name('pos.cart');

    // Sales
    Route::get('/sales', \App\Livewire\Backend\Sale\IndexComponent::class)->name('sales.index');
    Route::get('/sales/create', \App\Livewire\Backend\Sale\CreateComponent::class)->name('sales.create');
    Route::get('/sales/{sale}/edit', \App\Livewire\Backend\Sale\EditComponent::class)->name('sales.edit');
    Route::get('/sales/{sale}', \App\Livewire\Backend\Sale\ViewComponent::class)->name('sales.view');

    // Invoices
    Route::get('/invoices', \App\Livewire\Backend\Invoice\IndexComponent::class)->name('invoices.index');
    Route::get('/invoices/{invoice}', \App\Livewire\Backend\Invoice\ViewComponent::class)->name('invoices.view');
    Route::get('/invoices/{invoice}/print', \App\Livewire\Backend\Invoice\PrintComponent::class)->name('invoices.print');

    // Returns
    Route::get('/returns', \App\Livewire\Backend\Return\IndexComponent::class)->name('returns.index');
    Route::get('/returns/create', \App\Livewire\Backend\Return\CreateComponent::class)->name('returns.create');
    Route::get('/returns/{return}', \App\Livewire\Backend\Return\ViewComponent::class)->name('returns.view');

    // Customer Management
    // Customers complete
    Route::get('/customers', \App\Livewire\Backend\Customer\IndexComponent::class)->name('customers.index');
    Route::get('/customers/create', \App\Livewire\Backend\Customer\CreateComponent::class)->name('customers.create');
    Route::get('/customers/{customer}/edit', \App\Livewire\Backend\Customer\EditComponent::class)->name('customers.edit');

    // Prescriptions
    Route::get('/prescriptions', \App\Livewire\Backend\Prescription\IndexComponent::class)->name('prescriptions.index');
    Route::get('/prescriptions/create', \App\Livewire\Backend\Prescription\CreateComponent::class)->name('prescriptions.create');
    Route::get('/prescriptions/{prescription}/edit', \App\Livewire\Backend\Prescription\EditComponent::class)->name('prescriptions.edit');
    Route::get('/prescriptions/{prescription}', \App\Livewire\Backend\Prescription\ViewComponent::class)->name('prescriptions.view');

    // Loyalty Program
    Route::get('/loyalty', \App\Livewire\Backend\Loyalty\IndexComponent::class)->name('loyalty.index');
    Route::get('/loyalty/create', \App\Livewire\Backend\Loyalty\CreateComponent::class)->name('loyalty.create');
    Route::get('/loyalty/{loyaltyProgram}/edit', \App\Livewire\Backend\Loyalty\EditComponent::class)->name('loyalty.edit');
    Route::get('/loyalty/transactions', \App\Livewire\Backend\Loyalty\TransactionComponent::class)->name('loyalty.transactions');

    // Financial Management
    // Expenses
    Route::get('/expenses', \App\Livewire\Backend\Expense\IndexComponent::class)->name('expenses.index');
    Route::get('/expenses/create', \App\Livewire\Backend\Expense\CreateComponent::class)->name('expenses.create');
    Route::get('/expenses/{expense}/edit', \App\Livewire\Backend\Expense\EditComponent::class)->name('expenses.edit');
    Route::get('/expenses/{expense}', \App\Livewire\Backend\Expense\ViewComponent::class)->name('expenses.view');

    // Shift Management
    Route::get('/shifts', \App\Livewire\Backend\Shift\IndexComponent::class)->name('shifts.index');
    Route::get('/shifts/create', \App\Livewire\Backend\Shift\CreateComponent::class)->name('shifts.create');
    Route::get('/shifts/{shift}/edit', \App\Livewire\Backend\Shift\EditComponent::class)->name('shifts.edit');
    Route::get('/shifts/{shift}', \App\Livewire\Backend\Shift\ViewComponent::class)->name('shifts.view');

    // Reports
    Route::get('/reports/sales', \App\Livewire\Backend\Report\SalesReportComponent::class)->name('reports.sales');
    Route::get('/reports/inventory', \App\Livewire\Backend\Report\InventoryReportComponent::class)->name('reports.inventory');
    Route::get('/reports/financial', \App\Livewire\Backend\Report\FinancialReportComponent::class)->name('reports.financial');
    Route::get('/reports/customers', \App\Livewire\Backend\Report\CustomerReportComponent::class)->name('reports.customers');

    // System Management
    // Users
    Route::get('/users', \App\Livewire\Backend\User\IndexComponent::class)->name('users.index');
    Route::get('/users/create', \App\Livewire\Backend\User\CreateComponent::class)->name('users.create');
    Route::get('/users/{user}/edit', \App\Livewire\Backend\User\EditComponent::class)->name('users.edit');
    Route::get('/users/{user}', \App\Livewire\Backend\User\ViewComponent::class)->name('users.view');

    // Settings
    Route::get('/settings/general', \App\Livewire\Backend\Setting\GeneralComponent::class)->name('settings.general');
    Route::get('/settings/tax', \App\Livewire\Backend\Setting\TaxComponent::class)->name('settings.tax');
    Route::get('/settings/discounts', \App\Livewire\Backend\Setting\DiscountComponent::class)->name('settings.discounts');
    Route::get('/settings/payment', \App\Livewire\Backend\Setting\PaymentComponent::class)->name('settings.payment');

    // Audit Logs
    Route::get('/audit-logs', \App\Livewire\Backend\AuditLog\IndexComponent::class)->name('audit-logs.index');
    Route::get('/audit-logs/{auditLog}', \App\Livewire\Backend\AuditLog\ViewComponent::class)->name('audit-logs.view');

    // Notifications
    Route::get('/notifications', \App\Livewire\Backend\Notification\IndexComponent::class)->name('notifications.index');
});
