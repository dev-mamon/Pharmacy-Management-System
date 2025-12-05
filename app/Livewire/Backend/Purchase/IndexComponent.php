<?php

namespace App\Livewire\Backend\Purchase;

use App\Models\Stock;
use App\Models\Branch;
use Livewire\Component;
use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Traits\WithCustomPagination;

class IndexComponent extends Component
{
    use WithPagination, WithCustomPagination;

    public $search = '';
    public $perPage = 14;
    public $supplierFilter = '';
    public $branchFilter = '';
    public $statusFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $selectedPurchases = [];
    public $selectAll = false;
    public $currentPagePurchaseIds = [];

    public function mount()
    {
        $this->getCurrentPagePurchaseIds();
    }
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPurchases = $this->getCurrentPagePurchaseIds();
        } else {
            $currentPageIds = $this->getCurrentPagePurchaseIds();
            $this->selectedPurchases = array_diff($this->selectedPurchases, $currentPageIds);
        }
    }

    public function updatedSelectedPurchases()
    {
        $currentPageIds = $this->getCurrentPagePurchaseIds();
        $selectedOnCurrentPage = array_intersect($this->selectedPurchases, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    protected function getCurrentPagePurchaseIds()
    {
        if (empty($this->currentPagePurchaseIds)) {
            $purchases = $this->purchases()->get();
            $this->currentPagePurchaseIds = $purchases->pluck('id')->toArray();
        }

        return $this->currentPagePurchaseIds;
    }

    public function updating($property, $value)
    {
        $resetProperties = ['search', 'perPage', 'supplierFilter', 'branchFilter', 'statusFilter', 'dateFrom', 'dateTo', 'sortField', 'sortDirection'];

        if (in_array($property, $resetProperties)) {
            $this->currentPagePurchaseIds = [];
            $this->selectAll = false;

            if ($property !== 'perPage') {
                $this->resetPage();
            }
        }

        if ($property === 'page') {
            $this->currentPagePurchaseIds = [];
            $this->selectAll = false;
        }
    }

    public function selectAllPurchases()
    {
        $allPurchaseIds = $this->purchases()
            ->pluck('id')
            ->toArray();

        $this->selectedPurchases = $allPurchaseIds;

        $currentPageIds = $this->getCurrentPagePurchaseIds();
        $selectedOnCurrentPage = array_intersect($this->selectedPurchases, $currentPageIds);
        $this->selectAll = count($selectedOnCurrentPage) === count($currentPageIds);
    }

    public function deleteSelected()
    {
        if (!empty($this->selectedPurchases)) {
            Purchase::whereIn('id', $this->selectedPurchases)->delete();
            $this->selectedPurchases = [];
            $this->selectAll = false;
            $this->currentPagePurchaseIds = [];
            session()->flash('success', 'Selected purchases deleted successfully.');
        }
    }

    public function deletePurchase($purchaseId)
    {
        $purchase = Purchase::findOrFail($purchaseId);

        if ($purchase->status === 'completed') {
            session()->flash('error', 'Cannot delete a completed purchase.');
            return;
        }

        $purchase->delete();

        if (in_array($purchaseId, $this->selectedPurchases)) {
            $this->selectedPurchases = array_diff($this->selectedPurchases, [$purchaseId]);
        }

        $this->currentPagePurchaseIds = [];

        session()->flash('message', 'Purchase deleted successfully.');
    }

 public function updateStatus($purchaseId, $status)
    {
        $purchase = Purchase::with('purchaseItems')->findOrFail($purchaseId);

        if ($status === 'completed' && $purchase->status !== 'completed') {
            // Update stock when completing purchase
            foreach ($purchase->purchaseItems as $item) {
                \App\Models\Stock::updateOrCreate(
                    [
                        'medicine_id' => $item->medicine_id,
                        'branch_id' => $purchase->branch_id,
                        'batch_number' => $item->batch_number,
                    ],
                    [
                        'quantity' => \DB::raw("quantity + {$item->quantity}"),
                        'purchase_price' => $item->purchase_price,
                        'selling_price' => $item->selling_price,
                        'expiry_date' => $item->expiry_date,
                        'reorder_level' => 10,
                    ]
                );
            }
        }

        $purchase->update(['status' => $status]);

        session()->flash('message', 'Purchase status updated successfully.');
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->supplierFilter = '';
        $this->branchFilter = '';
        $this->statusFilter = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->selectedPurchases = [];
        $this->selectAll = false;
        $this->currentPagePurchaseIds = [];
        $this->resetPage();
    }

    protected function purchases()
    {
        return Purchase::with(['supplier', 'branch', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('purchase_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('supplier', function ($supplierQuery) {
                          $supplierQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->supplierFilter, function ($query) {
                $query->where('supplier_id', $this->supplierFilter);
            })
            ->when($this->branchFilter, function ($query) {
                $query->where('branch_id', $this->branchFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('purchase_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('purchase_date', '<=', $this->dateTo);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $purchases = $this->purchases()->paginate($this->perPage);
        $suppliers = Supplier::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();

        return view('livewire.backend.purchase.index-component', [
            'purchases' => $purchases,
            'suppliers' => $suppliers,
            'branches' => $branches,
            'paginator' => $purchases,
            'pageRange' => $this->getPageRange($purchases),
        ])->layout('layouts.backend.app');
    }
}
