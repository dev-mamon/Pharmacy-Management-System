<?php

namespace App\Livewire\Backend\Sale;

use App\Models\Sale;
use App\Traits\WithCustomPagination;
use Livewire\Component;
use Livewire\WithPagination;

class IndexComponent extends Component
{
    use WithCustomPagination, WithPagination;

    public $search = '';

    public $perPage = 10;

    public $startDate = '';

    public $endDate = '';

    public $statusFilter = '';

    public $paymentMethodFilter = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    public $selectedSales = [];

    public $selectAll = false;

    public $currentPageSaleIds = [];

    // Modal properties
    public $showDeleteModal = false;

    public $saleToDelete = null;

    public $isBulkDelete = false;

    public function mount()
    {
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->getCurrentPageSaleIds();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedSales = $this->getCurrentPageSaleIds();
        } else {
            $currentPageIds = $this->getCurrentPageSaleIds();
            $this->selectedSales = array_diff($this->selectedSales, $currentPageIds);
        }
    }

    public function updatedSelectedSales()
    {
        $currentPageIds = $this->getCurrentPageSaleIds();
        $selectedOnCurrentPage = array_intersect($this->selectedSales, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    protected function getCurrentPageSaleIds()
    {
        if (empty($this->currentPageSaleIds)) {
            $sales = $this->sales()->get();
            $this->currentPageSaleIds = $sales->pluck('id')->toArray();
        }

        return $this->currentPageSaleIds;
    }

    public function updating($property, $value)
    {
        $resetProperties = ['search', 'perPage', 'startDate', 'endDate', 'statusFilter', 'paymentMethodFilter', 'sortField', 'sortDirection'];

        if (in_array($property, $resetProperties)) {
            $this->currentPageSaleIds = [];
            $this->selectAll = false;

            if ($property !== 'perPage') {
                $this->resetPage();
            }
        }

        if ($property === 'page') {
            $this->currentPageSaleIds = [];
            $this->selectAll = false;
        }
    }

    /**
     * Select all sales across all pages (filtered results)
     */
    public function selectAllSales()
    {
        $allSaleIds = $this->sales()
            ->pluck('id')
            ->toArray();

        $this->selectedSales = $allSaleIds;

        $currentPageIds = $this->getCurrentPageSaleIds();
        $selectedOnCurrentPage = array_intersect($this->selectedSales, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    /**
     * Confirm deletion for a single sale
     */
    public function confirmDelete($saleId)
    {
        $this->saleToDelete = $saleId;
        $this->isBulkDelete = false;
        $this->showDeleteModal = true;
    }

    /**
     * Confirm deletion for selected sales
     */
    public function confirmBulkDelete()
    {
        if (! empty($this->selectedSales)) {
            $this->isBulkDelete = true;
            $this->showDeleteModal = true;
        }
    }

    /**
     * Close the delete modal
     */
    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->saleToDelete = null;
        $this->isBulkDelete = false;
    }

    /**
     * Perform the actual deletion
     */
    public function performDelete()
    {
        if ($this->isBulkDelete && ! empty($this->selectedSales)) {
            // Bulk delete selected sales
            Sale::whereIn('id', $this->selectedSales)->delete();
            $this->selectedSales = [];
            $this->selectAll = false;
            $this->currentPageSaleIds = [];
            session()->flash('success', 'Selected sales deleted successfully.');
        } elseif ($this->saleToDelete) {
            // Single sale delete
            $sale = Sale::find($this->saleToDelete);

            if ($sale) {
                $sale->delete();

                if (in_array($this->saleToDelete, $this->selectedSales)) {
                    $this->selectedSales = array_diff($this->selectedSales, [$this->saleToDelete]);
                }

                $this->currentPageSaleIds = [];

                session()->flash('message', 'Sale deleted successfully.');
            }
        }

        $this->closeDeleteModal();
    }

    public function updateStatus($saleId, $status)
    {
        $sale = Sale::findOrFail($saleId);
        $sale->update([
            'status' => $status,
        ]);

        session()->flash('message', 'Sale status updated successfully.');
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    // Helper method to get sales query
    protected function sales()
    {
        return Sale::with(['branch', 'user', 'saleItems'])
            ->withCount('saleItems')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoice_number', 'like', '%'.$this->search.'%')
                        ->orWhere('customer_name', 'like', '%'.$this->search.'%')
                        ->orWhere('customer_phone', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('sale_date', [$this->startDate, $this->endDate]);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->paymentMethodFilter, function ($query) {
                $query->where('payment_method', $this->paymentMethodFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $sales = $this->sales()->paginate($this->perPage);

        // Get sales statistics
        $totalSales = Sale::count();
        $todaySales = Sale::whereDate('sale_date', today())->count();
        $totalRevenue = Sale::where('status', 'completed')->sum('grand_total');
        $averageSale = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        $salesStats = [
            'total_sales' => $totalSales,
            'today_sales' => $todaySales,
            'total_revenue' => $totalRevenue,
            'average_sale' => $averageSale,
        ];

        return view('livewire.backend.sale.index-component', [
            'sales' => $sales,
            'salesStats' => $salesStats,
            'paginator' => $sales,
            'pageRange' => $this->getPageRange($sales),
        ])->layout('layouts.backend.app');
    }
}
