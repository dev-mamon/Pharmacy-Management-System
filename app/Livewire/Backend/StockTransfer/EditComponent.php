<?php

namespace App\Livewire\Backend\StockTransfer;

use App\Models\Branch;
use Livewire\Component;
use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\TransferItem;
use Illuminate\Support\Facades\DB;

class EditComponent extends Component
{
    public $transfer_id;
    public $transfer_number;
    public $from_branch_id;
    public $to_branch_id;
    public $transfer_date;
    public $notes = '';
    public $status;

    public $items = [];
    public $medicineOptions = [];
    public $originalItems = [];

    public function mount($id)
    {
        $this->transfer_id = $id;
        $transfer = StockTransfer::with(['transferItems.medicine', 'fromBranch', 'toBranch'])->findOrFail($id);

        $this->transfer_number = $transfer->transfer_number;
        $this->from_branch_id = $transfer->from_branch_id;
        $this->to_branch_id = $transfer->to_branch_id;
        $this->transfer_date = $transfer->transfer_date->format('Y-m-d');
        $this->notes = $transfer->notes;
        $this->status = $transfer->status;

        // Load transfer items
        foreach ($transfer->transferItems as $item) {
            // Get stock info for the medicine
            $stock = Stock::where('branch_id', $transfer->from_branch_id)
                ->where('medicine_id', $item->medicine_id)
                ->first();

            $this->items[] = [
                'id' => $item->id,
                'medicine_id' => $item->medicine_id,
                'medicine_name' => $item->medicine->name . ' (' . $item->medicine->generic_name . ')',
                'batch_number' => $stock->batch_number ?? '',
                'available_quantity' => $stock->quantity ?? 0,
                'quantity' => $item->quantity,
                'unit_price' => $stock->selling_price ?? 0,
                'total_price' => ($stock->selling_price ?? 0) * $item->quantity,
                'expiry_date' => $stock->expiry_date ? $stock->expiry_date->format('Y-m-d') : null
            ];
        }

        $this->originalItems = $this->items;

        // Load medicine options for the selected branch
        $this->loadAvailableMedicines();
    }

    public function updated($property, $value)
    {
        if ($property === 'from_branch_id') {
            $this->loadAvailableMedicines();

            // Clear medicine selections when branch changes
            foreach ($this->items as $index => $item) {
                $this->items[$index]['medicine_id'] = '';
                $this->items[$index]['medicine_name'] = '';
                $this->items[$index]['batch_number'] = '';
                $this->items[$index]['available_quantity'] = 0;
                $this->items[$index]['unit_price'] = 0;
                $this->items[$index]['total_price'] = 0;
            }
        }

        // Handle medicine selection change
        if (str_starts_with($property, 'items.')) {
            $parts = explode('.', $property);
            if (count($parts) === 3) {
                [$array, $index, $field] = $parts;

                if ($field === 'medicine_id' && $value) {
                    $this->selectMedicine($index, $value);
                }

                if (in_array($field, ['quantity', 'unit_price'])) {
                    $this->calculateTotal($index);

                    // Validate quantity
                    if ($field === 'quantity') {
                        $available = $this->items[$index]['available_quantity'] ?? 0;
                        if ($value > $available) {
                            $this->items[$index]['quantity'] = $available;
                            session()->flash('error', 'Item ' . ($index + 1) . ': Quantity cannot exceed available stock (' . $available . ')');
                        }
                    }
                }
            }
        }
    }

    protected function loadAvailableMedicines()
    {
        if (!$this->from_branch_id) {
            $this->medicineOptions = [];
            return;
        }

        $availableMedicines = Stock::with('medicine')
            ->where('branch_id', $this->from_branch_id)
            ->where('quantity', '>', 0)
            ->get()
            ->map(function ($stock) {
                return [
                    'id' => $stock->medicine_id,
                    'stock_id' => $stock->id,
                    'name' => $stock->medicine->name,
                    'generic_name' => $stock->medicine->generic_name,
                    'batch_number' => $stock->batch_number,
                    'available_quantity' => $stock->quantity,
                    'expiry_date' => $stock->expiry_date->format('Y-m-d'),
                    'unit_price' => $stock->selling_price
                ];
            });

        // Create grouped options for dropdown
        $this->medicineOptions = $availableMedicines
            ->groupBy('id')
            ->map(function ($batches, $medicineId) {
                $firstBatch = $batches->first();
                return [
                    'medicine_id' => $medicineId,
                    'medicine_name' => $firstBatch['name'],
                    'generic_name' => $firstBatch['generic_name'],
                    'batches' => $batches->values()->all()
                ];
            })
            ->values()
            ->all();
    }

    public function selectMedicine($index, $medicineId)
    {
        // Find the selected medicine from available medicines
        $stock = Stock::where('branch_id', $this->from_branch_id)
            ->where('medicine_id', $medicineId)
            ->where('quantity', '>', 0)
            ->first();

        if ($stock) {
            $this->items[$index] = [
                'medicine_id' => $medicineId,
                'medicine_name' => $stock->medicine->name . ' (' . $stock->medicine->generic_name . ')',
                'batch_number' => $stock->batch_number,
                'available_quantity' => $stock->quantity,
                'quantity' => 1,
                'unit_price' => $stock->selling_price,
                'total_price' => $stock->selling_price,
                'expiry_date' => $stock->expiry_date->format('Y-m-d')
            ];

            $this->calculateTotal($index);
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'medicine_id' => '',
            'medicine_name' => '',
            'batch_number' => '',
            'available_quantity' => 0,
            'quantity' => 1,
            'unit_price' => 0,
            'total_price' => 0,
            'expiry_date' => null
        ];
    }

    public function removeItem($index)
    {
        // Store the original item for stock restoration
        $originalItem = $this->originalItems[$index] ?? null;

        if ($originalItem && isset($originalItem['id'])) {
            // This item was in the original transfer, we need to restore stock
            $this->restoreStockForItem($originalItem);
        }

        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    protected function restoreStockForItem($item)
    {
        if (isset($item['medicine_id']) && $item['medicine_id']) {
            $stock = Stock::where('branch_id', $this->from_branch_id)
                ->where('medicine_id', $item['medicine_id'])
                ->first();

            if ($stock) {
                $stock->increment('quantity', $item['quantity']);
            }
        }
    }

    public function calculateTotal($index)
    {
        if (isset($this->items[$index])) {
            $quantity = $this->items[$index]['quantity'] ?? 1;
            $unitPrice = $this->items[$index]['unit_price'] ?? 0;
            $this->items[$index]['total_price'] = $quantity * $unitPrice;
        }
    }

    public function update()
    {
        $this->validate([
            'from_branch_id' => 'required|different:to_branch_id',
            'to_branch_id' => 'required',
            'transfer_date' => 'required|date',
            'status' => 'required|in:pending,approved,rejected,completed',
            'items.*.medicine_id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ], [
            'from_branch_id.different' => 'From and To branches must be different.',
            'items.*.medicine_id.required' => 'Please select a medicine for all items.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
        ]);

        // Check if all items have valid quantities
        $hasError = false;
        foreach ($this->items as $index => $item) {
            if ($item['quantity'] > $item['available_quantity']) {
                $hasError = true;
                session()->flash('error', 'Item ' . ($index + 1) . ': Quantity exceeds available stock (' . $item['available_quantity'] . ')');
            }
        }

        if ($hasError) {
            return;
        }

        DB::beginTransaction();

        try {
            $transfer = StockTransfer::findOrFail($this->transfer_id);

            // Update the transfer
            $transfer->update([
                'from_branch_id' => $this->from_branch_id,
                'to_branch_id' => $this->to_branch_id,
                'transfer_date' => $this->transfer_date,
                'status' => $this->status,
                'notes' => $this->notes,
            ]);

            // Get existing transfer item IDs
            $existingItemIds = [];

            // Process each item
            foreach ($this->items as $itemData) {
                if (isset($itemData['id'])) {
                    // Update existing item
                    $item = TransferItem::find($itemData['id']);
                    if ($item) {
                        $oldQuantity = $item->quantity;
                        $item->update([
                            'medicine_id' => $itemData['medicine_id'],
                            'quantity' => $itemData['quantity']
                        ]);

                        // Adjust stock quantities
                        $this->adjustStockQuantities($itemData, $oldQuantity);

                        $existingItemIds[] = $item->id;
                    }
                } else {
                    // Create new item
                    $item = TransferItem::create([
                        'stock_transfer_id' => $transfer->id,
                        'medicine_id' => $itemData['medicine_id'],
                        'quantity' => $itemData['quantity'],
                    ]);

                    // Deduct from source stock
                    $this->deductFromSourceStock($itemData);

                    $existingItemIds[] = $item->id;
                }
            }

            // Delete removed items
            $removedItems = TransferItem::where('stock_transfer_id', $transfer->id)
                ->whereNotIn('id', $existingItemIds)
                ->get();

            foreach ($removedItems as $item) {
                $item->delete();
            }

            // Handle status change to completed
            if ($this->status === 'completed' && $transfer->status !== 'completed') {
                $this->completeTransfer($transfer);
            }

            DB::commit();

            session()->flash('success', 'Stock transfer updated successfully.');
            return redirect()->route('admin.stock-transfers.view', $transfer->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to update transfer: ' . $e->getMessage());
        }
    }

    protected function adjustStockQuantities($itemData, $oldQuantity)
    {
        $difference = $itemData['quantity'] - $oldQuantity;

        if ($difference != 0) {
            $stock = Stock::where('branch_id', $this->from_branch_id)
                ->where('medicine_id', $itemData['medicine_id'])
                ->where('batch_number', $itemData['batch_number'])
                ->first();

            if ($stock) {
                if ($difference > 0) {
                    // Need to deduct more
                    if ($stock->quantity >= $difference) {
                        $stock->decrement('quantity', $difference);
                    }
                } else {
                    // Need to add back (restore)
                    $stock->increment('quantity', abs($difference));
                }
            }
        }
    }

    protected function deductFromSourceStock($itemData)
    {
        $stock = Stock::where('branch_id', $this->from_branch_id)
            ->where('medicine_id', $itemData['medicine_id'])
            ->where('batch_number', $itemData['batch_number'])
            ->first();

        if ($stock) {
            $stock->decrement('quantity', $itemData['quantity']);
        }
    }

    protected function completeTransfer($transfer)
    {
        // When marking as completed, ensure stock is properly transferred
        // This is already handled during item creation/update
        // You might want to add additional logic here if needed
    }

    public function render()
    {
        return view('livewire.backend.stock-transfer.edit-component', [
            'branches' => Branch::all(),
            'totalItems' => count(array_filter($this->items, fn($item) => !empty($item['medicine_id']))),
            'grandTotal' => array_sum(array_column($this->items, 'total_price')),
        ])->layout('layouts.backend.app');
    }
}
