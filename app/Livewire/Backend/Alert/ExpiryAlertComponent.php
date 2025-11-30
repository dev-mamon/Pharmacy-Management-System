<?php

namespace App\Livewire\Backend\Alert;

use App\Models\Stock;
use Livewire\Component;
use App\Models\ExpiryAlert;
use Livewire\WithPagination;
use App\Traits\WithCustomPagination;

class ExpiryAlertComponent extends Component
{
    use WithPagination, WithCustomPagination;

    public $search = '';
    public $alertLevelFilter = '';
    public $branchFilter = '';
    public $perPage = 10;
    public $sortField = 'expiry_date';
    public $sortDirection = 'asc';

    // Bulk actions
    public $selectedAlerts = [];
    public $selectAll = false;

    protected $listeners = ['refreshAlerts' => '$refresh'];

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

    public function updatingAlertLevelFilter()
    {
        $this->resetPage();
    }

    public function updatingBranchFilter()
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
        $this->alertLevelFilter = '';
        $this->branchFilter = '';
        $this->resetPage();
    }

    public function markAsNotified($alertId)
    {
        $alert = ExpiryAlert::findOrFail($alertId);
        $alert->update([
            'is_notified' => true,
            'notified_at' => now(),
        ]);

        session()->flash('message', 'Alert marked as notified successfully.');
    }

    public function markAllAsNotified()
    {
        ExpiryAlert::whereIn('id', $this->selectedAlerts)
            ->update([
                'is_notified' => true,
                'notified_at' => now(),
            ]);

        $this->selectedAlerts = [];
        $this->selectAll = false;

        session()->flash('message', 'Selected alerts marked as notified successfully.');
    }

    public function deleteAlert($alertId)
    {
        $alert = ExpiryAlert::findOrFail($alertId);
        $alert->delete();

        session()->flash('message', 'Alert deleted successfully.');
    }

    public function deleteSelectedAlerts()
    {
        ExpiryAlert::whereIn('id', $this->selectedAlerts)->delete();

        $this->selectedAlerts = [];
        $this->selectAll = false;

        session()->flash('message', 'Selected alerts deleted successfully.');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedAlerts = $this->getAlertsQuery()->pluck('id')->toArray();
        } else {
            $this->selectedAlerts = [];
        }
    }

    public function getAlertStats()
    {
        return [
            'total' => ExpiryAlert::count(),
            'critical' => ExpiryAlert::where('alert_level', 'critical')->count(),
            'warning' => ExpiryAlert::where('alert_level', 'warning')->count(),
            'info' => ExpiryAlert::where('alert_level', 'info')->count(),
            'notified' => ExpiryAlert::where('is_notified', true)->count(),
            'pending' => ExpiryAlert::where('is_notified', false)->count(),
        ];
    }

    private function getAlertsQuery()
    {
        return ExpiryAlert::with(['stock.medicine', 'branch'])
            ->when($this->search, function ($query) {
                $query->whereHas('stock.medicine', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('batch_number', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->alertLevelFilter, function ($query) {
                $query->where('alert_level', $this->alertLevelFilter);
            })
            ->when($this->branchFilter, function ($query) {
                $query->where('branch_id', $this->branchFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $alerts = $this->getAlertsQuery()->paginate($this->perPage);
        $stats = $this->getAlertStats();

        return view('livewire.backend.alert.expiry-alert-component', [
            'alerts' => $alerts,
            'stats' => $stats,
            'alertLevels' => [
                '' => 'All Levels',
                'critical' => 'Critical',
                'warning' => 'Warning',
                'info' => 'Info'
            ],
            'branches' => \App\Models\Branch::all(),
             'paginator' => $alerts,
            'pageRange' => $this->getPageRange($alerts),
        ])->layout('layouts.backend.app');
    }
}
