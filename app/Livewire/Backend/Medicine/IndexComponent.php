<?php

namespace App\Livewire\Backend\Medicine;

use Livewire\Component;
use App\Models\Category;
use App\Models\Medicine;
use Livewire\WithPagination;
use App\Traits\WithCustomPagination;

class IndexComponent extends Component
{
    use WithPagination,WithCustomPagination;

    public $search = '';
    public $perPage = 10;
    public $categoryFilter = '';
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

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function deleteMedicine($medicineId)
    {
        $medicine = Medicine::findOrFail($medicineId);

        // Check if medicine has stock or sales
        if ($medicine->stocks()->count() > 0 || $medicine->saleItems()->count() > 0) {
            session()->flash('error', 'Cannot delete medicine. It has associated stock or sales records.');
            return;
        }

        $medicine->delete();
        session()->flash('message', 'Medicine deleted successfully.');
    }

    public function toggleStatus($medicineId)
    {
        $medicine = Medicine::findOrFail($medicineId);
        $medicine->update([
            'is_active' => !$medicine->is_active
        ]);

        session()->flash('message', 'Medicine status updated successfully.');
    }

    public function render()
    {
        $medicines = Medicine::with(['category', 'stocks'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('generic_name', 'like', '%' . $this->search . '%')
                      ->orWhere('brand_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $categories = Category::where('is_active', true)->get();

        return view('livewire.backend.medicine.index-component', [
            'medicines' => $medicines,
            'categories' => $categories,
            'paginator' => $medicines,
            'pageRange' => $this->getPageRange($medicines),
        ])->layout('layouts.backend.app');
    }
}
