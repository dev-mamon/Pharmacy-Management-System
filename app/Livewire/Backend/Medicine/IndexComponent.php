<?php

namespace App\Livewire\Backend\Medicine;

use Livewire\Component;
use App\Models\Medicine;
use App\Models\Category;
use Livewire\WithPagination;
use App\Traits\WithCustomPagination;

class IndexComponent extends Component
{
    use WithPagination, WithCustomPagination;

    public $search = '';
    public $perPage = 10;
    public $categoryFilter = '';
    public $prescriptionFilter = '';
    public $statusFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $selectedMedicines = [];
    public $selectAll = false;
    public $currentPageMedicineIds = [];

    // Modal properties
    public $showDeleteModal = false;
    public $medicineToDelete = null;
    public $isBulkDelete = false;

    public function mount()
    {
        $this->getCurrentPageMedicineIds();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedMedicines = $this->getCurrentPageMedicineIds();
        } else {
            $currentPageIds = $this->getCurrentPageMedicineIds();
            $this->selectedMedicines = array_diff($this->selectedMedicines, $currentPageIds);
        }
    }

    public function updatedSelectedMedicines()
    {
        $currentPageIds = $this->getCurrentPageMedicineIds();
        $selectedOnCurrentPage = array_intersect($this->selectedMedicines, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    protected function getCurrentPageMedicineIds()
    {
        if (empty($this->currentPageMedicineIds)) {
            $medicines = $this->medicines()->get();
            $this->currentPageMedicineIds = $medicines->pluck('id')->toArray();
        }

        return $this->currentPageMedicineIds;
    }

    public function updating($property, $value)
    {
        $resetProperties = ['search', 'perPage', 'categoryFilter', 'prescriptionFilter', 'statusFilter', 'sortField', 'sortDirection'];

        if (in_array($property, $resetProperties)) {
            $this->currentPageMedicineIds = [];
            $this->selectAll = false;

            if ($property !== 'perPage') {
                $this->resetPage();
            }
        }

        if ($property === 'page') {
            $this->currentPageMedicineIds = [];
            $this->selectAll = false;
        }
    }

    /**
     * Select all medicines across all pages (filtered results)
     */
    public function selectAllMedicines()
    {
        $allMedicineIds = $this->medicines()
            ->pluck('id')
            ->toArray();

        $this->selectedMedicines = $allMedicineIds;

        $currentPageIds = $this->getCurrentPageMedicineIds();
        $selectedOnCurrentPage = array_intersect($this->selectedMedicines, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    /**
     * Confirm deletion for a single medicine
     */
    public function confirmDelete($medicineId)
    {
        $this->medicineToDelete = $medicineId;
        $this->isBulkDelete = false;
        $this->showDeleteModal = true;
    }

    /**
     * Confirm deletion for selected medicines
     */
    public function confirmBulkDelete()
    {
        if (!empty($this->selectedMedicines)) {
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
        $this->medicineToDelete = null;
        $this->isBulkDelete = false;
    }

    /**
     * Perform the actual deletion
     */
    public function performDelete()
    {
        if ($this->isBulkDelete && !empty($this->selectedMedicines)) {
            // Bulk delete selected medicines
            Medicine::whereIn('id', $this->selectedMedicines)->delete();
            $this->selectedMedicines = [];
            $this->selectAll = false;
            $this->currentPageMedicineIds = [];
            session()->flash('success', 'Selected medicines deleted successfully.');
        } elseif ($this->medicineToDelete) {
            // Single medicine delete
            $medicine = Medicine::find($this->medicineToDelete);

            if ($medicine) {
                $medicine->delete();

                if (in_array($this->medicineToDelete, $this->selectedMedicines)) {
                    $this->selectedMedicines = array_diff($this->selectedMedicines, [$this->medicineToDelete]);
                }

                $this->currentPageMedicineIds = [];

                session()->flash('message', 'Medicine deleted successfully.');
            }
        }

        $this->closeDeleteModal();
    }

    public function toggleStatus($medicineId)
    {
        $medicine = Medicine::findOrFail($medicineId);
        $medicine->update([
            'is_active' => !$medicine->is_active
        ]);

        session()->flash('message', 'Medicine status updated successfully.');
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

    // Helper method to get medicines query
    protected function medicines()
    {
        return Medicine::with('category')
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
            ->when($this->prescriptionFilter, function ($query) {
                $query->where('requires_prescription', $this->prescriptionFilter === 'yes');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('is_active', $this->statusFilter === 'active');
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $medicines = $this->medicines()->paginate($this->perPage);
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        // Get medicine statistics
        $medicineStats = [
            'total' => $medicines->total(),
            'active' => $medicines->where('is_active', true)->count(),
            'prescription_required' => $medicines->where('requires_prescription', true)->count(),
            'categories' => Category::where('is_active', true)->count(),
        ];

        return view('livewire.backend.medicine.index-component', [
            'medicines' => $medicines,
            'categories' => $categories,
            'medicineStats' => $medicineStats,
            'paginator' => $medicines,
            'pageRange' => $this->getPageRange($medicines),
        ])->layout('layouts.backend.app');
    }
}
