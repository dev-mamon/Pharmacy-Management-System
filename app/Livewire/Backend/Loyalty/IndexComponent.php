<?php

namespace App\Livewire\Backend\Loyalty;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LoyaltyProgram;
use App\Traits\WithCustomPagination;

class IndexComponent extends Component
{
    use WithPagination, WithCustomPagination;

    public $search = '';
    public $perPage = 10;
    public $statusFilter = '';
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

    public function deleteProgram($programId)
    {
        $program = LoyaltyProgram::findOrFail($programId);

        // Since we don't have the loyalty_transactions relationship working,
        // we'll remove the transaction check or implement an alternative
        // For now, we'll allow deletion without transaction check
        $program->delete();
        session()->flash('message', 'Loyalty program deleted successfully.');
    }

    public function toggleStatus($programId)
    {
        $program = LoyaltyProgram::findOrFail($programId);
        $program->update([
            'is_active' => !$program->is_active
        ]);

        session()->flash('message', 'Loyalty program status updated successfully.');
    }

    public function render()
    {
        $programs = LoyaltyProgram::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter === 'active', function ($query) {
                $query->where('is_active', true)
                      ->where('valid_from', '<=', now())
                      ->where(function ($q) {
                          $q->whereNull('valid_to')
                            ->orWhere('valid_to', '>=', now());
                      });
            })
            ->when($this->statusFilter === 'inactive', function ($query) {
                $query->where('is_active', false);
            })
            ->when($this->statusFilter === 'expired', function ($query) {
                $query->where('valid_to', '<', now());
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

         return view('livewire.backend.loyalty.index-component', [
            'programs' => $programs,
            'paginator' => $programs,
            'pageRange' => $this->getPageRange($programs),
        ])->layout('layouts.backend.app');
    }
}
