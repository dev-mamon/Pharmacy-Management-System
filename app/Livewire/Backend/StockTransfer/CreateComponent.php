<?php

namespace App\Livewire\Backend\StockTransfer;

use App\Models\Branch;
use App\Models\Medicine;
use Livewire\Component;
use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\TransferItem;
use Illuminate\Support\Facades\DB;

class CreateComponent extends Component
{
    public $transfer_number;
    public $from_branch_id;
    public $to_branch_id;
    public $transfer_date;
    public $notes = '';
    public $status = 'pending';

    public $items = [];
    public $availableMedicines = [];
    public $medicineOptions = [];

    public function mount()
    {
        $this->transfer_number = 'TRF-' . date('Ymd') . '-' . rand(1000, 9999);
        $this->transfer_date = date('Y-m-d');

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

    public function updated($property, $value)
    {
        if ($property === 'from_branch_id') {
            $this->loadAvailableMedicines();
        }

        // Handle medicine selection change
        if (str_starts_with($property, 'items.')) {
            $parts = explode('.', $property);
            if (count($parts) === 3) {
                [$array, $index, $field] = $parts;

                if ($field === 'medicine_id' && $value) {
                    $this->selectMedicine($index, $value);
                }

                if ($field === 'quantity') {
                    $available = $this->items[$index]['available_quantity'] ?? 0;
                    if ($value > $available) {
                        $this->items[$index]['quantity'] = $available;
                        session()->flash('error', 'Quantity cannot exceed available stock: ' . $available);
                    }
                    $this->calculateTotal($index);
                }

                if ($field === 'unit_price') {
                    $this->calculateTotal($index);
                }
            }
        }
    }

    protected function loadAvailableMedicines()
    {
        if (!$this->from_branch_id) {
            $this->availableMedicines = [];
            $this->medicineOptions = [];
            return;
        }

        $this->availableMedicines = Stock::with('medicine')
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
        $this->medicineOptions = $this->availableMedicines
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
        // Find the selected medicine from availableMedicines
        $selectedMedicine = collect($this->availableMedicines)
            ->where('id', $medicineId)
            ->first();

        if ($selectedMedicine) {
            $this->items[$index] = [
                'medicine_id' => $selectedMedicine['id'],
                'medicine_name' => $selectedMedicine['name'] . ' (' . $selectedMedicine['generic_name'] . ')',
                'batch_number' => $selectedMedicine['batch_number'],
                'available_quantity' => $selectedMedicine['available_quantity'],
                'quantity' => 1,
                'unit_price' => $selectedMedicine['unit_price'],
                'total_price' => $selectedMedicine['unit_price'],
                'expiry_date' => $selectedMedicine['expiry_date']
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
        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
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

    public function save()
    {
        $this->validate([
            'transfer_number' => 'required|unique:stock_transfers,transfer_number',
            'from_branch_id' => 'required|different:to_branch_id',
            'to_branch_id' => 'required',
            'transfer_date' => 'required|date',
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
            // Create the transfer
            $transfer = StockTransfer::create([
                'transfer_number' => $this->transfer_number,
                'from_branch_id' => $this->from_branch_id,
                'to_branch_id' => $this->to_branch_id,
                'user_id' => auth()->id() ?? 1,
                'transfer_date' => $this->transfer_date,
                'status' => $this->status,
                'notes' => $this->notes,
            ]);

            // Create transfer items and deduct from source stock
            foreach ($this->items as $item) {
                // Create transfer item
                TransferItem::create([
                    'stock_transfer_id' => $transfer->id,
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                ]);

                // Deduct from source branch stock
                $stock = Stock::where('branch_id', $this->from_branch_id)
                    ->where('medicine_id', $item['medicine_id'])
                    ->where('batch_number', $item['batch_number'])
                    ->first();

                if ($stock) {
                    $stock->decrement('quantity', $item['quantity']);
                }

                // Add to destination branch stock (as pending transfer)
                $destinationStock = Stock::firstOrCreate(
                    [
                        'branch_id' => $this->to_branch_id,
                        'medicine_id' => $item['medicine_id'],
                        'batch_number' => $item['batch_number'],
                    ],
                    [
                        'purchase_price' => $stock->purchase_price ?? 0,
                        'selling_price' => $item['unit_price'],
                        'quantity' => 0,
                        'reorder_level' => $stock->reorder_level ?? 10,
                        'expiry_date' => $item['expiry_date'],
                    ]
                );
            }

            DB::commit();

            session()->flash('success', 'Stock transfer created successfully.');
            return redirect()->route('admin.stock-transfers.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create transfer: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.stock-transfer.create-component', [
            'branches' => Branch::all(),
            'totalItems' => count(array_filter($this->items, fn($item) => !empty($item['medicine_id']))),
            'grandTotal' => array_sum(array_column($this->items, 'total_price')),
        ])->layout('layouts.backend.app');
    }
}
