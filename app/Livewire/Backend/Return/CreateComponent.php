<?php

namespace App\Livewire\Backend\Return;

use App\Models\Branch;
use App\Models\Sale;
use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateComponent extends Component
{
    public $branches = [];

    public $branchId = '';

    public $saleId = '';

    public $sale = null;

    public $saleItems = [];

    public $returnItems = [];

    public $selectedItems = [];

    public $reason = '';

    public $notes = '';

    public $returnDate;

    public $totalAmount = 0;

    public $showSaleSearch = false;

    public $saleSearch = '';

    public $filteredSales = [];

    protected $rules = [
        'branchId' => 'required|exists:branches,id',
        'saleId' => 'required|exists:sales,id',
        'returnDate' => 'required|date',
        'reason' => 'required|string|min:10|max:500',
        'returnItems.*.return_quantity' => 'required|integer|min:1',
        'returnItems.*.unit_price' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->branches = Branch::all();
        $this->returnDate = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.backend.return.create-component')->layout('layouts.backend.app');
    }

    public function updatedBranchId()
    {
        $this->resetSaleSelection();
        $this->showSaleSearch = false;
    }

    public function updatedSaleSearch()
    {
        if (strlen($this->saleSearch) >= 2) {
            $this->filteredSales = Sale::where('branch_id', $this->branchId)
                ->where('status', 'completed') // Show only completed sales
                ->where(function ($query) {
                    $query->where('invoice_number', 'like', '%'.$this->saleSearch.'%')
                        ->orWhereHas('customer', function ($q) {
                            $q->where('name', 'like', '%'.$this->saleSearch.'%')
                                ->orWhere('phone', 'like', '%'.$this->saleSearch.'%');
                        });
                })
                ->with(['customer', 'items.medicine'])
                ->orderBy('sale_date', 'desc')
                ->limit(10)
                ->get();

            $this->showSaleSearch = true;
        } else {
            $this->filteredSales = [];
            $this->showSaleSearch = false;
        }
    }

    public function openSaleSearch()
    {
        if ($this->branchId) {
            $this->showSaleSearch = true;
            $this->filteredSales = Sale::where('branch_id', $this->branchId)
                ->where('status', 'completed')
                ->with(['customer', 'items.medicine'])
                ->orderBy('sale_date', 'desc')
                ->limit(10)
                ->get();
        } else {
            session()->flash('error', 'Please select a branch first.');
        }
    }

    public function closeSaleSearch()
    {
        $this->showSaleSearch = false;
        $this->filteredSales = [];
    }

    public function selectSale($saleId)
    {
        $this->saleId = $saleId;
        $this->sale = Sale::with(['items.medicine', 'customer'])->find($saleId);
        $this->saleItems = $this->sale->items;
        $this->showSaleSearch = false;
        $this->saleSearch = $this->sale->invoice_number.' - '.($this->sale->customer->name ?? 'Walk-in Customer');
    }

    public function toggleItemSelection($itemId)
    {
        if (in_array($itemId, $this->selectedItems)) {
            $this->selectedItems = array_diff($this->selectedItems, [$itemId]);
            unset($this->returnItems[$itemId]);
        } else {
            $this->selectedItems[] = $itemId;
            $item = $this->saleItems->firstWhere('id', $itemId);
            if ($item) {
                $this->returnItems[$itemId] = [
                    'sale_item_id' => $item->id,
                    'medicine_id' => $item->medicine_id,
                    'medicine_name' => $item->medicine->name,
                    'generic_name' => $item->medicine->generic_name,
                    'batch_number' => $item->batch_number,
                    'sold_quantity' => $item->quantity,
                    'returned_quantity' => $item->returned_quantity,
                    'max_returnable' => $item->remaining_quantity,
                    'return_quantity' => 1,
                    'unit_price' => $item->unit_price,
                    'total_amount' => $item->unit_price,
                ];
            }
        }
        $this->calculateTotal();
    }

    public function updateReturnQuantity($itemId, $quantity)
    {
        if (isset($this->returnItems[$itemId])) {
            $max = $this->returnItems[$itemId]['max_returnable'];
            $newQuantity = max(1, min($quantity, $max));
            $this->returnItems[$itemId]['return_quantity'] = $newQuantity;
            $this->returnItems[$itemId]['total_amount'] =
                $newQuantity * $this->returnItems[$itemId]['unit_price'];
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $this->totalAmount = collect($this->returnItems)->sum('total_amount');
    }

    public function createReturn()
    {
        $this->validate();

        if (empty($this->returnItems)) {
            session()->flash('error', 'Please select at least one item to return.');

            return;
        }

        DB::beginTransaction();
        try {
            // Create sales return
            $salesReturn = SalesReturn::create([
                'return_number' => SalesReturn::generateReturnNumber(),
                'sale_id' => $this->saleId,
                'branch_id' => $this->branchId,
                'user_id' => auth()->id(),
                'customer_id' => $this->sale->customer_id,
                'return_date' => $this->returnDate,
                'total_amount' => $this->totalAmount,
                'reason' => $this->reason,
                'notes' => $this->notes,
                'status' => 'completed',
            ]);

            // Create return items
            foreach ($this->returnItems as $returnItem) {
                SalesReturnItem::create([
                    'sales_return_id' => $salesReturn->id,
                    'sale_item_id' => $returnItem['sale_item_id'],
                    'medicine_id' => $returnItem['medicine_id'],
                    'batch_number' => $returnItem['batch_number'],
                    'return_quantity' => $returnItem['return_quantity'],
                    'unit_price' => $returnItem['unit_price'],
                    'total_amount' => $returnItem['total_amount'],
                ]);

                // Update medicine stock
                $stock = Stock::where('medicine_id', $returnItem['medicine_id'])
                    ->where('branch_id', $this->branchId)
                    ->where('batch_number', $returnItem['batch_number'])
                    ->first();

                if ($stock) {
                    $stock->increment('current_stock', $returnItem['return_quantity']);
                } else {
                    // If batch not found, create new stock entry
                    Stock::create([
                        'medicine_id' => $returnItem['medicine_id'],
                        'branch_id' => $this->branchId,
                        'batch_number' => $returnItem['batch_number'],
                        'current_stock' => $returnItem['return_quantity'],
                        'created_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            session()->flash('message', 'Sales return created successfully.');

            return redirect()->route('admin.returns.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error creating sales return: '.$e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'branchId', 'saleId', 'sale', 'saleItems',
            'returnItems', 'selectedItems', 'reason', 'notes',
            'totalAmount', 'saleSearch', 'filteredSales', 'showSaleSearch',
        ]);
        $this->returnDate = date('Y-m-d');
    }

    private function resetSaleSelection()
    {
        $this->reset(['saleId', 'sale', 'saleItems', 'returnItems', 'selectedItems', 'saleSearch']);
    }

    // Listen for outside click events
    public function listenForOutsideClick()
    {
        $this->dispatch('clicked-outside-sale-search');
    }
}
