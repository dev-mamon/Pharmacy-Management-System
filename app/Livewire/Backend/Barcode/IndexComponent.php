<?php

namespace App\Livewire\Backend\Barcode;

use App\Traits\WithCustomPagination;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Barcode;
use App\Models\Medicine;

class IndexComponent extends Component
{
    use WithPagination,WithCustomPagination;

    public $search = '';
    public $medicineFilter = '';
    public $barcodeTypeFilter = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedItems = [];
    public $selectAll = false;
    public $showDeleteModal = false;
    public $isBulkDelete = false;
    public $barcodeToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'medicineFilter' => ['except' => ''],
        'barcodeTypeFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->barcodes->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        $this->selectAll = count($this->selectedItems) === $this->barcodes->count();
    }

    public function selectAllBarcodes()
    {
        $this->selectedItems = $this->barcodes->pluck('id')->toArray();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete($id)
    {
        $this->barcodeToDelete = $id;
        $this->isBulkDelete = false;
        $this->showDeleteModal = true;
    }

    public function confirmBulkDelete()
    {
        if (count($this->selectedItems) > 0) {
            $this->isBulkDelete = true;
            $this->showDeleteModal = true;
        }
    }

    public function performDelete()
    {
        if ($this->isBulkDelete) {
            Barcode::whereIn('id', $this->selectedItems)->delete();
            $this->selectedItems = [];
            $this->selectAll = false;
            session()->flash('message', count($this->selectedItems) . ' barcodes deleted successfully!');
        } else {
            $barcode = Barcode::findOrFail($this->barcodeToDelete);
            $barcode->delete();
            session()->flash('message', 'Barcode deleted successfully!');
        }

        $this->closeDeleteModal();
        $this->resetPage();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->barcodeToDelete = null;
        $this->isBulkDelete = false;
    }

    public function toggleStatus($id)
    {
        $barcode = Barcode::findOrFail($id);
        $barcode->update(['is_active' => !$barcode->is_active]);

        $this->dispatch('refreshComponent');
    }

    public function getBarcodesProperty()
    {
        return Barcode::query()
            ->with('medicine')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('barcode', 'like', '%' . $this->search . '%')
                      ->orWhereHas('medicine', function ($q2) {
                          $q2->where('name', 'like', '%' . $this->search . '%')
                             ->orWhere('generic_name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->medicineFilter, function ($query) {
                $query->where('medicine_id', $this->medicineFilter);
            })
            ->when($this->barcodeTypeFilter, function ($query) {
                $query->where('barcode_type', $this->barcodeTypeFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('is_active', $this->statusFilter === 'active');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function getMedicinesProperty()
    {
        return Medicine::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function getBarcodeTypesProperty()
    {
        return [
            'CODE128' => 'CODE128',
            'CODE39' => 'CODE39',
            'EAN13' => 'EAN-13',
            'EAN8' => 'EAN-8',
            'UPCA' => 'UPC-A',
            'UPCE' => 'UPC-E',
        ];
    }

    public function render()
    {
        return view('livewire.backend.barcode.index-component', [
            'barcodes' => $this->barcodes,
            'medicines' => $this->medicines,
            'barcodeTypes' => $this->barcodeTypes,
            'pageRange' => $this->getPageRange($this->barcodes),
        ])->layout('layouts.backend.app');
    }
}
