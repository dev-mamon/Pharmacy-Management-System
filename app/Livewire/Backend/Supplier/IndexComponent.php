<?php

namespace App\Livewire\Backend\Supplier;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;
use App\Traits\WithCustomPagination;

class IndexComponent extends Component
{
    use WithPagination, WithCustomPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

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

    public function deleteSupplier($supplierId)
    {
        $supplier = Supplier::findOrFail($supplierId);

        // Check if supplier has purchases
        if ($supplier->purchases()->count() > 0) {
            session()->flash('error', 'Cannot delete supplier. It has associated purchase records.');
            return;
        }

        $supplier->delete();
        session()->flash('message', 'Supplier deleted successfully.');
    }

    public function toggleStatus($supplierId)
    {
        $supplier = Supplier::findOrFail($supplierId);
        $supplier->update([
            'is_active' => !$supplier->is_active
        ]);

        session()->flash('message', 'Supplier status updated successfully.');
    }

    public function render()
    {
        $suppliers = Supplier::withCount('purchases')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('contact_person', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.supplier.index-component',[
            'suppliers' => $suppliers,
            'paginator' => $suppliers,
            'pageRange' => $this->getPageRange($suppliers),
        ])->layout('layouts.backend.app');
    }
}
