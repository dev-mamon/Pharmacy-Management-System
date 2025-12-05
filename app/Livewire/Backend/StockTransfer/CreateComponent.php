<?php

namespace App\Livewire\Backend\StockTransfer;

use App\Models\Branch;
use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateComponent extends Component
{
    public $transferId = null;
    public $transfer_number = '';
    public $from_branch_id = '';
    public $to_branch_id = '';
    public $transfer_date;
    public $notes = '';

    public $items = [];
    public $availableStocks = [];

    public $selectedStock = null;
    public $selectedQuantity = 1;
    public $itemNotes = '';
    public $isEditing = false;

    protected $rules = [
        'from_branch_id' => 'required|exists:branches,id',
        'to_branch_id' => 'required|exists:branches,id|different:from_branch_id',
        'transfer_date' => 'required|date',
        'notes' => 'nullable|string|max:500',
        'items' => 'required|array|min:1',
        'items.*.stock_id' => 'required|exists:stocks,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.notes' => 'nullable|string|max:255',
    ];

    public function mount($id = null)
    {
        $this->transfer_date = now()->format('Y-m-d');

        if ($id) {
            $this->isEditing = true;
            $transfer = StockTransfer::with(['items.stock.medicine'])->findOrFail($id);

            if ($transfer->status !== 'pending') {
                session()->flash('error', 'Only pending transfers can be edited.');
                return redirect()->route('stock-transfers.index');
            }

            $this->transferId = $id;
            $this->transfer_number = $transfer->transfer_number;
            $this->from_branch_id = $transfer->from_branch_id;
            $this->to_branch_id = $transfer->to_branch_id;
            $this->transfer_date = $transfer->transfer_date->format('Y-m-d');
            $this->notes = $transfer->notes;

            foreach ($transfer->items as $item) {
                $this->items[] = [
                    'id' => $item->id,
                    'stock_id' => $item->stock_id,
                    'stock' => $item->stock,
                    'quantity' => $item->quantity,
                    'notes' => $item->notes,
                ];
            }

            $this->updatedFromBranchId($this->from_branch_id);
        }
    }

    public function updatedFromBranchId($value)
    {
        if ($value) {
            $this->availableStocks = Stock::where('branch_id', $value)
                ->where('quantity', '>', 0)
                ->with('medicine')
                ->get()
                ->filter(function ($stock) {
                    // Filter out stocks already in items
                    return !collect($this->items)->contains('stock_id', $stock->id);
                })
                ->values();
        } else {
            $this->availableStocks = [];
        }
        $this->selectedStock = null;
    }

    public function addItem()
    {
        $this->validate([
            'selectedStock' => 'required|exists:stocks,id',
            'selectedQuantity' => 'required|integer|min:1',
        ]);

        $stock = Stock::find($this->selectedStock);

        // Check available quantity
        if ($this->selectedQuantity > $stock->quantity) {
            session()->flash('error', 'Insufficient stock. Available: ' . $stock->quantity);
            return;
        }

        $this->items[] = [
            'stock_id' => $this->selectedStock,
            'stock' => $stock,
            'quantity' => $this->selectedQuantity,
            'notes' => $this->itemNotes,
        ];

        $this->selectedStock = null;
        $this->selectedQuantity = 1;
        $this->itemNotes = '';

        // Refresh available stocks
        $this->updatedFromBranchId($this->from_branch_id);
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->updatedFromBranchId($this->from_branch_id);
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            if ($this->isEditing) {
                $transfer = StockTransfer::findOrFail($this->transferId);

                if ($transfer->status !== 'pending') {
                    throw new \Exception('Only pending transfers can be edited.');
                }

                $transfer->update([
                    'from_branch_id' => $this->from_branch_id,
                    'to_branch_id' => $this->to_branch_id,
                    'transfer_date' => $this->transfer_date,
                    'notes' => $this->notes,
                ]);

                // Remove existing items
                StockTransferItem::where('stock_transfer_id', $transfer->id)->delete();

                $message = 'Stock transfer updated successfully.';
            } else {
                $transfer = StockTransfer::create([
                    'from_branch_id' => $this->from_branch_id,
                    'to_branch_id' => $this->to_branch_id,
                    'user_id' => Auth::id(),
                    'transfer_date' => $this->transfer_date,
                    'notes' => $this->notes,
                    'status' => 'pending',
                ]);

                $message = 'Stock transfer created successfully.';
            }

            foreach ($this->items as $item) {
                StockTransferItem::create([
                    'stock_transfer_id' => $transfer->id,
                    'stock_id' => $item['stock_id'],
                    'quantity' => $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            DB::commit();

            session()->flash('success', $message);
            return redirect()->route('stock-transfers.view', $transfer->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to save stock transfer: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $branches = Branch::all();

        return view('livewire.backend.stock-transfer.create-component', [
            'branches' => $branches,
            'availableStocks' => $this->availableStocks,
        ])->layout('layouts.backend.app');
    }
}
