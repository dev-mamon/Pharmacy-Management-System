<?php

namespace App\Livewire\Backend\Purchase;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Branch;
use Livewire\Component;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Str;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;

class CreateComponent extends Component
{
    public $purchase_number;
    public $supplier_id;
    public $branch_id;
    public $purchase_date;
    public $notes;
    public $user_id;

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
        'user_id' => 'required|exists:users,id',
        'notes' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.medicine_id' => 'required|exists:medicines,id',
        'items.*.batch_number' => 'required|string',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.expiry_date' => 'required|date|after_or_equal:today',
    ];

    public function mount()
    {
        $this->purchase_number = 'PUR-' . date('Ymd') . '-' . Str::random(6);
        $this->purchase_date = Carbon::today()->format('Y-m-d');
        $this->allMedicines = Medicine::where('is_active', true)->get();
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'medicine_id' => '',
            'batch_number' => 'BATCH-' . Str::random(6),
            'quantity' => 1,
            'unit_price' => 0,
            'total_price' => 0,
            'expiry_date' => Carbon::today()->addYear()->format('Y-m-d'),
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotals();
    }

    public function updated($propertyName)
    {
        // If any item property is updated
        if (str_starts_with($propertyName, 'items.')) {
            $parts = explode('.', $propertyName);

            if (count($parts) >= 3) {
                $index = $parts[1];
                $field = $parts[2];

                // Recalculate item total when quantity or unit_price changes
                if ($field === 'quantity' || $field === 'unit_price') {
                    if (isset($this->items[$index]['quantity']) && isset($this->items[$index]['unit_price'])) {
                        // Convert string values to float/int for calculation
                        $quantity = (float) $this->items[$index]['quantity'];
                        $unitPrice = (float) $this->items[$index]['unit_price'];

                        $this->items[$index]['total_price'] = $quantity * $unitPrice;
                        $this->calculateTotals();
                    }
                }
            }
        }

        // Recalculate totals when discount or tax_rate changes
        if (in_array($propertyName, ['discount', 'tax_rate'])) {
            $this->calculateTotals();
        }
    }

    private function calculateTotals()
    {
        // Calculate subtotal from all items
        $this->subtotal = 0;
        foreach ($this->items as $item) {
            if (isset($item['total_price'])) {
                $this->subtotal += (float) $item['total_price'];
            }
        }

        // Convert discount and tax_rate to float
        $discount = (float) $this->discount;
        $taxRate = (float) $this->tax_rate;

        // Calculate tax amount and grand total
        $taxableAmount = $this->subtotal - $discount;
        $this->tax_amount = $taxableAmount * ($taxRate / 100);
        $this->grand_total = $taxableAmount + $this->tax_amount;
    }

    public function save()
    {
        // Convert string values to proper types before validation
        foreach ($this->items as $key => $item) {
            $this->items[$key]['quantity'] = (int) $item['quantity'];
            $this->items[$key]['unit_price'] = (float) $item['unit_price'];
        }

        $this->discount = (float) $this->discount;
        $this->tax_rate = (float) $this->tax_rate;

        $this->validate();

        try {
            DB::beginTransaction();

            $purchase = Purchase::create([
                'purchase_number' => $this->purchase_number,
                'supplier_id' => $this->supplier_id,
                'branch_id' => $this->branch_id,
                'user_id' => $this->user_id,
                'purchase_date' => $this->purchase_date,
                'total_amount' => $this->subtotal,
                'discount' => $this->discount,
                'tax_amount' => $this->tax_amount,
                'grand_total' => $this->grand_total,
                'status' => 'pending',
                'notes' => $this->notes,
            ]);

            foreach ($this->items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'medicine_id' => $item['medicine_id'],
                    'batch_number' => $item['batch_number'],
                    'expiry_date' => $item['expiry_date'],
                    'quantity' => (int) $item['quantity'],
                    'purchase_price' => (float) $item['unit_price'],
                    'selling_price' => (float) $item['unit_price'] * 1.3,
                    'total_amount' => (float) $item['total_price'],
                ]);
            }

            DB::commit();

            session()->flash('success', 'Purchase created successfully.');
            return redirect()->route('admin.purchases.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error creating purchase: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        $users = User::where('is_active', true)->get();

        $filteredMedicines = $this->allMedicines;
        if ($this->searchMedicine) {
            $filteredMedicines = $this->allMedicines->filter(function ($medicine) {
                return stripos($medicine->name, $this->searchMedicine) !== false ||
                       stripos($medicine->generic_name, $this->searchMedicine) !== false;
            });
        }

        return view('livewire.backend.purchase.create-component', [
            'suppliers' => $suppliers,
            'branches' => $branches,
            'users' => $users,
            'filteredMedicines' => $filteredMedicines,
        ])->layout('layouts.backend.app');
    }
}
