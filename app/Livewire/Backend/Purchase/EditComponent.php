<?php

namespace App\Livewire\Backend\Purchase;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Branch;
use App\Models\Medicine;
use App\Models\PurchaseItem;
use Livewire\Component;
use Carbon\Carbon;

class EditComponent extends Component
{
    public $purchase;
    public $purchase_number;
    public $supplier_id;
    public $branch_id;
    public $purchase_date;
    public $notes;
    public $status;

    public $items = [];
    public $subtotal = 0;
    public $discount = 0;
    public $tax_rate = 0;
    public $tax_amount = 0;
    public $grand_total = 0;

    public $allMedicines = [];
    public $searchMedicine = '';

    protected $rules = [
        'supplier_id' => 'required|exists:suppliers,id',
        'branch_id' => 'required|exists:branches,id',
        'purchase_date' => 'required|date',
        'notes' => 'nullable|string',
        'status' => 'required|in:pending,completed,cancelled',
        'items' => 'required|array|min:1',
        'items.*.medicine_id' => 'required|exists:medicines,id',
        'items.*.batch_number' => 'required|string',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.expiry_date' => 'required|date',
    ];

    public function mount($id)
    {
        $this->purchase = Purchase::with(['purchaseItems.medicine'])->findOrFail($id);

        if ($this->purchase->status !== 'pending') {
            session()->flash('error', 'Only pending purchases can be edited.');
            return redirect()->route('admin.purchases.index');
        }

        $this->purchase_number = $this->purchase->purchase_number;
        $this->supplier_id = $this->purchase->supplier_id;
        $this->branch_id = $this->purchase->branch_id;
        $this->purchase_date = $this->purchase->purchase_date->format('Y-m-d');
        $this->notes = $this->purchase->notes;
        $this->status = $this->purchase->status;
        $this->discount = $this->purchase->discount;
        $this->tax_amount = $this->purchase->tax_amount;
        $this->tax_rate = $this->purchase->tax_amount > 0 ?
            ($this->purchase->tax_amount / ($this->purchase->total_amount - $this->purchase->discount)) * 100 : 0;

        $this->allMedicines = Medicine::where('is_active', true)->get();

        foreach ($this->purchase->purchaseItems as $item) {
            $this->items[] = [
                'id' => $item->id,
                'medicine_id' => $item->medicine_id,
                'medicine_name' => $item->medicine->name,
                'batch_number' => $item->batch_number,
                'quantity' => $item->quantity,
                'unit_price' => $item->purchase_price,
                'total_price' => $item->total_amount,
                'expiry_date' => $item->expiry_date->format('Y-m-d'),
            ];
        }

        $this->calculateTotals();
    }

    public function addItem()
    {
        $this->items[] = [
            'id' => null,
            'medicine_id' => '',
            'medicine_name' => '',
            'batch_number' => 'BATCH-' . \Illuminate\Support\Str::random(6),
            'quantity' => 1,
            'unit_price' => 0,
            'total_price' => 0,
            'expiry_date' => Carbon::today()->addYear()->format('Y-m-d'),
        ];
    }

    public function removeItem($index)
    {
        $item = $this->items[$index];

        if (!empty($item['id'])) {
            PurchaseItem::find($item['id'])->delete();
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotals();
    }

    public function updatedItems($value, $key)
    {
        if (str_contains($key, '.')) {
            [$index, $field] = explode('.', $key);
            $index = (int) $index;

            if ($field === 'medicine_id' && !empty($value)) {
                $medicine = Medicine::find($value);
                if ($medicine) {
                    $this->items[$index]['medicine_name'] = $medicine->name;
                    $this->items[$index]['unit_price'] = $medicine->purchase_price ?? 0;
                    if (empty($this->items[$index]['batch_number']) || $this->items[$index]['batch_number'] === 'BATCH-') {
                        $this->items[$index]['batch_number'] = 'BATCH-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(6));
                    }
                }
            }

            if (in_array($field, ['quantity', 'unit_price'])) {
                $quantity = $this->items[$index]['quantity'] ?? 1;
                $unitPrice = $this->items[$index]['unit_price'] ?? 0;
                $this->items[$index]['total_price'] = $quantity * $unitPrice;
            }
        }

        $this->calculateTotals();
    }

    public function updatedDiscount()
    {
        $this->calculateTotals();
    }

    public function updatedTaxRate()
    {
        $this->calculateTotals();
    }

    private function calculateTotals()
    {
        $this->subtotal = collect($this->items)->sum('total_price');
        $this->tax_amount = ($this->subtotal - $this->discount) * ($this->tax_rate / 100);
        $this->grand_total = ($this->subtotal - $this->discount) + $this->tax_amount;
    }

    public function update()
    {
        $this->validate();

        try {
            \DB::beginTransaction();

            $this->purchase->update([
                'supplier_id' => $this->supplier_id,
                'branch_id' => $this->branch_id,
                'purchase_date' => $this->purchase_date,
                'total_amount' => $this->subtotal,
                'discount' => $this->discount,
                'tax_amount' => $this->tax_amount,
                'grand_total' => $this->grand_total,
                'status' => $this->status,
                'notes' => $this->notes,
            ]);

            $existingItemIds = collect($this->items)->pluck('id')->filter()->toArray();

            PurchaseItem::where('purchase_id', $this->purchase->id)
                ->whereNotIn('id', $existingItemIds)
                ->delete();

            foreach ($this->items as $item) {
                if (!empty($item['id'])) {
                    PurchaseItem::find($item['id'])->update([
                        'medicine_id' => $item['medicine_id'],
                        'batch_number' => $item['batch_number'],
                        'quantity' => $item['quantity'],
                        'purchase_price' => $item['unit_price'],
                        'selling_price' => $item['unit_price'] * 1.3,
                        'total_amount' => $item['total_price'],
                        'expiry_date' => $item['expiry_date'],
                    ]);
                } else {
                    PurchaseItem::create([
                        'purchase_id' => $this->purchase->id,
                        'medicine_id' => $item['medicine_id'],
                        'batch_number' => $item['batch_number'],
                        'quantity' => $item['quantity'],
                        'purchase_price' => $item['unit_price'],
                        'selling_price' => $item['unit_price'] * 1.3,
                        'total_amount' => $item['total_price'],
                        'expiry_date' => $item['expiry_date'],
                    ]);
                }
            }

            \DB::commit();

            session()->flash('success', 'Purchase updated successfully.');
            return redirect()->route('admin.purchases.index');
        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Error updating purchase: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();

        $filteredMedicines = $this->allMedicines;
        if ($this->searchMedicine) {
            $filteredMedicines = $this->allMedicines->filter(function ($medicine) {
                return stripos($medicine->name, $this->searchMedicine) !== false ||
                       stripos($medicine->generic_name, $this->searchMedicine) !== false;
            });
        }

        return view('livewire.backend.purchase.edit-component', [
            'suppliers' => $suppliers,
            'branches' => $branches,
            'filteredMedicines' => $filteredMedicines,
        ])->layout('layouts.backend.app');
    }
}
