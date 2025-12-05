<?php

namespace App\Livewire\Backend\Alert;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LowStockAlert;
use App\Models\Stock;
use App\Models\Branch;

class LowStockComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $branchFilter = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $pageRange = 3;

    // For create/edit modal
    public $showModal = false;
    public $modalTitle = '';
    public $editMode = false;

    // Form fields
    public $alertId;
    public $stock_id;
    public $branch_id;
    public $current_quantity;
    public $reorder_level;
    public $is_notified = false;

    public $stocks = [];
    public $branches = [];

    protected $listeners = ['refreshAlerts' => '$refresh'];

    protected $rules = [
        'stock_id' => 'required|exists:stocks,id',
        'branch_id' => 'required|exists:branches,id',
        'current_quantity' => 'required|integer|min:0',
        'reorder_level' => 'required|integer|min:1',
        'is_notified' => 'boolean',
    ];

    public function mount()
    {
        $this->loadStocksAndBranches();
    }

    public function loadStocksAndBranches()
    {
        $this->stocks = Stock::with('medicine')->where('quantity', '>', 0)->get();
        $this->branches = Branch::where('is_active', true)->get();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'branchFilter', 'statusFilter']);
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->modalTitle = 'Create Low Stock Alert';
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $alert = LowStockAlert::findOrFail($id);

        $this->alertId = $alert->id;
        $this->stock_id = $alert->stock_id;
        $this->branch_id = $alert->branch_id;
        $this->current_quantity = $alert->current_quantity;
        $this->reorder_level = $alert->reorder_level;
        $this->is_notified = $alert->is_notified;

        $this->modalTitle = 'Edit Low Stock Alert';
        $this->editMode = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'alertId',
            'stock_id',
            'branch_id',
            'current_quantity',
            'reorder_level',
            'is_notified',
        ]);
    }

    public function saveAlert()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $alert = LowStockAlert::findOrFail($this->alertId);
                $alert->update([
                    'stock_id' => $this->stock_id,
                    'branch_id' => $this->branch_id,
                    'current_quantity' => $this->current_quantity,
                    'reorder_level' => $this->reorder_level,
                    'is_notified' => $this->is_notified,
                    'notified_at' => $this->is_notified ? now() : null,
                ]);
                $message = 'Alert updated successfully.';
            } else {
                LowStockAlert::create([
                    'stock_id' => $this->stock_id,
                    'branch_id' => $this->branch_id,
                    'current_quantity' => $this->current_quantity,
                    'reorder_level' => $this->reorder_level,
                    'is_notified' => $this->is_notified,
                    'notified_at' => $this->is_notified ? now() : null,
                ]);
                $message = 'Alert created successfully.';
            }

            // Update related stock reorder level
            $stock = Stock::find($this->stock_id);
            if ($stock) {
                $stock->update(['reorder_level' => $this->reorder_level]);
            }

            session()->flash('success', $message);
            $this->closeModal();
            $this->dispatch('refreshAlerts');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function markAsNotified($id)
    {
        try {
            $alert = LowStockAlert::findOrFail($id);
            $alert->update([
                'is_notified' => true,
                'notified_at' => now()
            ]);

            session()->flash('success', 'Alert marked as notified successfully.');
            $this->dispatch('refreshAlerts');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating alert: ' . $e->getMessage());
        }
    }

    public function markAllAsNotified()
    {
        try {
            $alerts = $this->alerts->where('is_notified', false);
            $count = $alerts->count();

            LowStockAlert::whereIn('id', $alerts->pluck('id')->toArray())->update([
                'is_notified' => true,
                'notified_at' => now()
            ]);

            session()->flash('success', $count . ' alert(s) marked as notified.');
            $this->dispatch('refreshAlerts');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating alerts: ' . $e->getMessage());
        }
    }

    public function deleteAlert($id)
    {
        try {
            $alert = LowStockAlert::findOrFail($id);
            $alert->delete();

            session()->flash('success', 'Alert deleted successfully.');
            $this->dispatch('refreshAlerts');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting alert: ' . $e->getMessage());
        }
    }

    public function getAlertsProperty()
    {
        return LowStockAlert::query()
            ->with(['stock.medicine', 'branch'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('stock.medicine', function ($sq) {
                        $sq->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('generic_name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->branchFilter, function ($query) {
                $query->where('branch_id', $this->branchFilter);
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'notified') {
                    $query->where('is_notified', true);
                } elseif ($this->statusFilter === 'pending') {
                    $query->where('is_notified', false);
                }
            })
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        // Statistics
        $totalAlerts = LowStockAlert::count();
        $pendingAlerts = LowStockAlert::where('is_notified', false)->count();
        $notifiedAlerts = LowStockAlert::where('is_notified', true)->count();

        return view('livewire.backend.alert.low-stock-component', [
            'alerts' => $this->alerts,
            'totalAlerts' => $totalAlerts,
            'pendingAlerts' => $pendingAlerts,
            'notifiedAlerts' => $notifiedAlerts,
        ])->layout('layouts.backend.app');
    }
}
