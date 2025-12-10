<?php

namespace App\Livewire\Backend\Return;

use App\Models\SalesReturn;
use App\Traits\WithCustomPagination;
use Livewire\Component;
use Livewire\WithPagination;

class IndexComponent extends Component
{
    use WithCustomPagination, WithPagination;

    public $search = '';

    public $startDate = '';

    public $endDate = '';

    public $statusFilter = '';

    public $perPage = 10;

    public $sortBy = 'return_date';

    public $sortDirection = 'desc';

    public $selectedReturns = [];

    public $selectAll = false;

    public $showDeleteModal = false;

    public $returnToDelete = null;

    public $isBulkDelete = false;

    protected $listeners = ['refreshReturns' => '$refresh'];

    public function mount()
    {
        $this->endDate = date('Y-m-d');
        $this->startDate = date('Y-m-d', strtotime('-30 days'));
    }

    public function render()
    {
        $query = SalesReturn::with(['sale', 'branch', 'customer', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('return_number', 'like', '%'.$this->search.'%')
                        ->orWhereHas('sale', function ($q) {
                            $q->where('invoice_number', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('customer', function ($q) {
                            $q->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('phone', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->when($this->startDate, function ($query) {
                $query->whereDate('return_date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('return_date', '<=', $this->endDate);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        $returns = $query->paginate($this->perPage);
        $stats = $this->getStats();

        return view('livewire.backend.return.index-component', [
            'returns' => $returns,
            'stats' => $stats, 'paginator' => $returns,
            'pageRange' => $this->getPageRange($returns),
        ])->layout('layouts.backend.app');
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function selectAllReturns()
    {
        if ($this->selectAll) {
            $this->selectedReturns = SalesReturn::pluck('id')->toArray();
        } else {
            $this->selectedReturns = [];
        }
    }

    public function updatedSelectedReturns()
    {
        $this->selectAll = count($this->selectedReturns) === SalesReturn::count();
    }

    public function confirmDelete($id)
    {
        $this->returnToDelete = $id;
        $this->isBulkDelete = false;
        $this->showDeleteModal = true;
    }

    public function confirmBulkDelete()
    {
        if (count($this->selectedReturns) > 0) {
            $this->isBulkDelete = true;
            $this->showDeleteModal = true;
        }
    }

    public function performDelete()
    {
        if ($this->isBulkDelete) {
            SalesReturn::whereIn('id', $this->selectedReturns)->delete();
            session()->flash('message', count($this->selectedReturns).' return(s) deleted successfully.');
            $this->selectedReturns = [];
        } else {
            $return = SalesReturn::find($this->returnToDelete);
            if ($return) {
                $return->delete();
                session()->flash('message', 'Return deleted successfully.');
            }
        }

        $this->closeDeleteModal();
        $this->dispatch('refreshReturns');
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->returnToDelete = null;
        $this->isBulkDelete = false;
    }

    private function getStats()
    {
        return [
            'total_returns' => SalesReturn::count(),
            'today_returns' => SalesReturn::whereDate('return_date', today())->count(),
            'total_amount' => SalesReturn::where('status', 'completed')->sum('total_amount'),
            'pending_count' => SalesReturn::where('status', 'pending')->count(),
        ];
    }
}
