<?php

namespace App\Livewire\Backend\Branch;

use App\Models\Branch;
use App\Traits\WithCustomPagination;
use Livewire\Component;
use Livewire\WithPagination;

class IndexComponent extends Component
{
    use WithPagination,WithCustomPagination;

    public $search = '';
    public $perPage = 10;
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

    public function deleteBranch($branchId)
    {
        $branch = Branch::findOrFail($branchId);
        $branch->delete();

        session()->flash('message', 'Branch deleted successfully.');
    }

    public function render()
    {
        $branches = Branch::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.branch.index-component', [
            'branches' => $branches,
            'paginator' => $branches,
            'pageRange' => $this->getPageRange($branches),
        ])->layout('layouts.backend.app');
    }
}
