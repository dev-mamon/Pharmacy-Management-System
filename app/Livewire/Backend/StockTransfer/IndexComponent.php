<?php

namespace App\Livewire\Backend\StockTransfer;

use App\Models\Branch;
use Livewire\Component;
use App\Models\Medicine;
use Livewire\WithPagination;
use App\Models\StockTransfer;
use App\Traits\WithCustomPagination;

class IndexComponent extends Component
{
    use WithPagination, WithCustomPagination;

    public $search = '';
    public $perPage = 10;
    public $medicineFilter = '';
    public $branchFilter = '';
    public $statusFilter = ''; // replaced stockStatus
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $selectedTransfers = [];
    public $selectAll = false;
    public $currentPageTransferIds = [];

    public function mount()
    {
        $this->getCurrentPageTransferIds();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedTransfers = $this->getCurrentPageTransferIds();
        } else {
            $currentPageIds = $this->getCurrentPageTransferIds();
            $this->selectedTransfers = array_diff($this->selectedTransfers, $currentPageIds);
        }
    }

    public function updatedSelectedTransfers()
    {
        $currentPageIds = $this->getCurrentPageTransferIds();
        $selectedOnCurrentPage = array_intersect($this->selectedTransfers, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    protected function getCurrentPageTransferIds()
    {
        if (empty($this->currentPageTransferIds)) {
            $transfers = $this->transfers()->get();
            $this->currentPageTransferIds = $transfers->pluck('id')->toArray();
        }

        return $this->currentPageTransferIds;
    }

    public function updating($property, $value)
    {
        $resetProperties = ['search', 'perPage', 'medicineFilter', 'branchFilter', 'statusFilter', 'sortField', 'sortDirection'];

        if (in_array($property, $resetProperties)) {
            $this->currentPageTransferIds = [];
            $this->selectAll = false;

            if ($property !== 'perPage') {
                $this->resetPage();
            }
        }

        if ($property === 'page') {
            $this->currentPageTransferIds = [];
            $this->selectAll = false;
        }
    }

    public function selectAllTransfers()
    {
        $allIds = $this->transfers()->pluck('id')->toArray();
        $this->selectedTransfers = $allIds;

        $currentPageIds = $this->getCurrentPageTransferIds();
        $selectedOnCurrentPage = array_intersect($this->selectedTransfers, $currentPageIds);

        $this->selectAll =
            count($selectedOnCurrentPage) === count($currentPageIds);
    }

    public function deleteSelected()
    {
        if (!empty($this->selectedTransfers)) {
            StockTransfer::whereIn('id', $this->selectedTransfers)->delete();
            $this->selectedTransfers = [];
            $this->selectAll = false;
            $this->currentPageTransferIds = [];
            session()->flash('success', 'Selected transfer records deleted successfully.');
        }
    }

    public function deleteTransfer($id)
    {
        $transfer = StockTransfer::findOrFail($id);
        $transfer->delete();

        if (in_array($id, $this->selectedTransfers)) {
            $this->selectedTransfers = array_diff($this->selectedTransfers, [$id]);
        }

        $this->currentPageTransferIds = [];
        session()->flash('message', 'Transfer deleted successfully.');
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
        $this->statusFilter = '';
        $this->selectedTransfers = [];
        $this->selectAll = false;
        $this->currentPageTransferIds = [];
        $this->resetPage();
    }

    /**
     * Transfer query builder
     */
    protected function transfers()
    {
        return StockTransfer::with([
            'fromBranch',
            'toBranch',
            'transferItems.medicine'
        ])
            ->when($this->search, function ($query) {
                $query->where('transfer_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('transferItems.medicine', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->medicineFilter, fn ($q) =>
                $q->whereHas('transferItems', fn ($ti) =>
                    $ti->where('medicine_id', $this->medicineFilter)
                )
            )
            ->when($this->branchFilter, function ($query) {
                $query->where(function ($q) {
                    $q->where('from_branch_id', $this->branchFilter)
                      ->orWhere('to_branch_id', $this->branchFilter);
                });
            })
            ->when($this->statusFilter, fn ($q) =>
                $q->where('status', $this->statusFilter)
            )
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $transfers = $this->transfers()->paginate($this->perPage);

        return view('livewire.backend.stock-transfer.index-component', [
            'transfers' => $transfers,
            'medicines' => Medicine::all(),
            'branches' => Branch::all(),
            'paginator' => $transfers,
            'pageRange' => $this->getPageRange($transfers),
        ])->layout('layouts.backend.app');
    }
}
