<?php

namespace App\Livewire\Backend\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use App\Traits\WithCustomPagination;

class IndexComponent extends Component
{
    use WithPagination , WithCustomPagination;

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

    public function deleteCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        // Check if category has medicines
        if ($category->medicines()->count() > 0) {
            session()->flash('error', 'Cannot delete category. It has associated medicines.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function toggleStatus($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->update([
            'is_active' => !$category->is_active
        ]);

        session()->flash('message', 'Category status updated successfully.');
    }

    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.category.index-component',
        [
            'categories' => $categories,
            'paginator' => $categories,
            'pageRange' => $this->getPageRange($categories),
        ])->layout('layouts.backend.app');
    }
}
