<?php

namespace App\Livewire\Backend\Stock;

use App\Models\Stock;
use App\Models\Branch;
use Livewire\Component;
use App\Models\Medicine;
use Livewire\WithPagination;
use App\Traits\WithCustomPagination;

class IndexComponent extends Component
{
    use WithPagination, WithCustomPagination;

    public $search = '';
    public $perPage = 10;
    public $medicineFilter = '';
    public $branchFilter = '';
    public $stockStatus = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $selectedStocks = [];
    public $selectAll = false;
    public $currentPageStockIds = [];

    public function mount()
    {
        // Initialize with current page stock IDs
        $this->getCurrentPageStockIds();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Get all stock IDs from the current page
            $this->selectedStocks = $this->getCurrentPageStockIds();
        } else {
            // Remove only current page IDs from selected
            $currentPageIds = $this->getCurrentPageStockIds();
            $this->selectedStocks = array_diff($this->selectedStocks, $currentPageIds);
        }
    }

    public function updatedSelectedStocks()
    {
        // Update selectAll checkbox based on selected items
        $currentPageIds = $this->getCurrentPageStockIds();
        $selectedOnCurrentPage = array_intersect($this->selectedStocks, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    protected function getCurrentPageStockIds()
    {
        if (empty($this->currentPageStockIds)) {
            $stocks = $this->stocks()->get();
            $this->currentPageStockIds = $stocks->pluck('id')->toArray();
        }

        return $this->currentPageStockIds;
    }

    // Reset currentPageStockIds when pagination or filters change
    public function updating($property, $value)
    {
        $resetProperties = ['search', 'perPage', 'medicineFilter', 'branchFilter', 'stockStatus', 'sortField', 'sortDirection'];

        if (in_array($property, $resetProperties)) {
            $this->currentPageStockIds = [];
            $this->selectAll = false;

            if ($property !== 'perPage') {
                $this->resetPage();
            }
        }

        if ($property === 'page') {
            $this->currentPageStockIds = [];
            $this->selectAll = false;
        }
    }

    /**
     * Select all stocks across all pages (filtered results)
     */
    public function selectAllStocks()
    {
        $allStockIds = $this->stocks()
            ->pluck('id')
            ->toArray();

        $this->selectedStocks = $allStockIds;

        // Check if all current page items are selected
        $currentPageIds = $this->getCurrentPageStockIds();
        $selectedOnCurrentPage = array_intersect($this->selectedStocks, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    /**
     * Delete selected stocks
     */
    public function deleteSelected()
    {
        if (!empty($this->selectedStocks)) {
            Stock::whereIn('id', $this->selectedStocks)->delete();
            $this->selectedStocks = [];
            $this->selectAll = false;
            $this->currentPageStockIds = [];
            session()->flash('success', 'Selected stock records deleted successfully.');
        }
    }

    /**
     * Delete single stock record
     */
    public function deleteStock($stockId)
    {
        $stock = Stock::findOrFail($stockId);

        // Check if stock has sales or other dependencies
        if ($stock->saleItems()->count() > 0) {
            session()->flash('error', 'Cannot delete stock. It has associated sales records.');
            return;
        }

        $stock->delete();

        // Remove from selected stocks if it was selected
        if (in_array($stockId, $this->selectedStocks)) {
            $this->selectedStocks = array_diff($this->selectedStocks, [$stockId]);
        }

        // Clear cached IDs
        $this->currentPageStockIds = [];

        session()->flash('message', 'Stock record deleted successfully.');
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->medicineFilter = '';
        $this->branchFilter = '';
        $this->stockStatus = '';
        $this->selectedStocks = [];
        $this->selectAll = false;
        $this->currentPageStockIds = [];
        $this->resetPage();
    }

    // Helper method to get stocks query
    protected function stocks()
    {
        return Stock::with(['medicine', 'branch'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('batch_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('medicine', function ($medicineQuery) {
                          $medicineQuery->where('name', 'like', '%' . $this->search . '%')
                                       ->orWhere('generic_name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->medicineFilter, function ($query) {
                $query->where('medicine_id', $this->medicineFilter);
            })
            ->when($this->branchFilter, function ($query) {
                $query->where('branch_id', $this->branchFilter);
            })
            ->when($this->stockStatus === 'low', function ($query) {
                $query->where('quantity', '<=', \DB::raw('reorder_level'))
                      ->where('quantity', '>', 0);
            })
            ->when($this->stockStatus === 'expiring', function ($query) {
                $query->where('expiry_date', '<=', now()->addDays(30));
            })
            ->when($this->stockStatus === 'out_of_stock', function ($query) {
                $query->where('quantity', '<=', 0);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $stocks = $this->stocks()->paginate($this->perPage);

        $medicines = Medicine::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();

        return view('livewire.backend.stock.index-component',
        [
        'stocks' => $stocks,
        'medicines' => $medicines,
        'branches' => $branches,
        'paginator' => $stocks,
        'pageRange' => $this->getPageRange($stocks),
        ])->layout('layouts.backend.app');
    }
}
