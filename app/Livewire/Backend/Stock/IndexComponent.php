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
        $this->resetPage();
    }

    public function render()
    {
        $stocks = Stock::with(['medicine', 'branch'])
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
                $query->where('quantity', '<=', \DB::raw('reorder_level'));
            })
            ->when($this->stockStatus === 'expiring', function ($query) {
                $query->where('expiry_date', '<=', now()->addDays(30));
            })
            ->when($this->stockStatus === 'out_of_stock', function ($query) {
                $query->where('quantity', '<=', 0);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

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
