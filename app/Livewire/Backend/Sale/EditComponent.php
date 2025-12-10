<?php

namespace App\Livewire\Backend\Sale;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditComponent extends Component
{
    public $sale;
    public $medicineSearch = '';
    public $dropdownSearch = '';
    public $customerSearch = '';

    public $medicineItems = [];
    public $originalMedicineItems = [];
    public $customerName = '';
    public $customerPhone = '';
    public $customerId = null;
    public $notes = '';
    public $saleDate;
    public $branchId;
    public $paymentMethod = 'cash';
    public $discount = 0;
    public $taxRate = 0;
    public $subTotal = 0;
    public $taxAmount = 0;
    public $grandTotal = 0;
    public $showMedicineDropdown = false;
    public $showCustomerDropdown = false;
    public $saleStatus = 'completed';

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($id)
    {
        $this->sale = Sale::with(['items.medicine', 'customer', 'branch'])->findOrFail($id);

        // Load sale data
        $this->saleDate = $this->sale->sale_date->format('Y-m-d');
        $this->branchId = $this->sale->branch_id;
        $this->paymentMethod = $this->sale->payment_method;
        $this->discount = $this->sale->discount;
        $this->taxRate = $this->sale->tax_amount ? ($this->sale->tax_amount / $this->sale->sub_total) * 100 : 5;
        $this->subTotal = $this->sale->sub_total;
        $this->taxAmount = $this->sale->tax_amount;
        $this->grandTotal = $this->sale->grand_total;
        $this->notes = $this->sale->notes;
        $this->saleStatus = $this->sale->status;

        // Load customer data
        if ($this->sale->customer_id) {
            $this->customerId = $this->sale->customer_id;
            $this->customerName = $this->sale->customer_name;
            $this->customerPhone = $this->sale->customer_phone;
        } else {
            $this->customerName = $this->sale->customer_name;
            $this->customerPhone = $this->sale->customer_phone;
        }

        // Load medicine items
        foreach ($this->sale->items as $item) {
            $stock = Stock::find($item->stock_id);
            $medicine = $item->medicine;

            $this->medicineItems[] = [
                'id' => $item->id, // Sale item ID
                'medicine_id' => $item->medicine_id,
                'medicine_name' => $medicine->name,
                'generic_name' => $medicine->generic_name,
                'stock_id' => $item->stock_id,
                'batch_number' => $item->batch_number,
                'expiry_date' => $item->expiry_date,
                'stock_quantity' => $stock ? ($stock->quantity + $item->quantity) : $item->quantity, // Add back sold quantity
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'purchase_price' => $item->purchase_price,
                'original_quantity' => $item->quantity, // Keep original for comparison
            ];
        }

        // Keep original items for stock restoration
        $this->originalMedicineItems = $this->medicineItems;
    }

    // Get filtered medicines for dropdown with search
    public function getFilteredMedicinesProperty()
    {
        if (!$this->branchId) {
            return collect();
        }

        $query = Medicine::with(['stocks' => function ($query) {
            $query->where('branch_id', $this->branchId)
                ->where('quantity', '>', 0);
        }])
            ->where('is_active', true);

        // Apply search filter
        if ($this->dropdownSearch) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->dropdownSearch . '%')
                  ->orWhere('generic_name', 'like', '%' . $this->dropdownSearch . '%')
                  ->orWhere('brand_name', 'like', '%' . $this->dropdownSearch . '%');
            });
        }

        return $query->limit(15)->get()
            ->map(function ($medicine) {
                $stock = $medicine->stocks->first();
                $medicine->current_stock = $stock ? $stock->quantity : 0;
                $medicine->selling_price = $stock ? $stock->selling_price : 0;
                $medicine->batch_number = $stock ? $stock->batch_number : null;
                $medicine->expiry_date = $stock ? $stock->expiry_date : null;
                $medicine->stock_id = $stock ? $stock->id : null;

                return $medicine;
            })
            ->filter(function ($medicine) {
                return $medicine->current_stock > 0;
            });
    }

    // Get filtered customers based on search
    public function getFilteredCustomersProperty()
    {
        if (empty($this->customerSearch)) {
            return Customer::where('is_active', true)
                ->orderBy('name')
                ->limit(10)
                ->get();
        }

        return Customer::where('is_active', true)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->customerSearch . '%')
                    ->orWhere('phone', 'like', '%' . $this->customerSearch . '%')
                    ->orWhere('customer_id', 'like', '%' . $this->customerSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->customerSearch . '%');
            })
            ->orderBy('name')
            ->limit(15)
            ->get();
    }

    // Show medicine dropdown
    public function showMedicineDropdown()
    {
        if (!$this->branchId) {
            session()->flash('error', 'Please select a branch first!');
            return;
        }

        $this->showMedicineDropdown = true;
        $this->dropdownSearch = '';
        $this->dispatch('focus-dropdown-search');
    }

    // Show customer dropdown
    public function showCustomerDropdown()
    {
        $this->showCustomerDropdown = true;
        $this->customerSearch = '';
        $this->dispatch('focus-customer-search');
    }

    // Select medicine from dropdown
    public function selectMedicineFromDropdown($medicineId)
    {
        $this->selectMedicine($medicineId);
        $this->dropdownSearch = '';
    }

    // Select customer from dropdown
    public function selectCustomerFromDropdown($customerId)
    {
        $customer = Customer::find($customerId);

        if ($customer) {
            $this->customerId = $customer->id;
            $this->customerName = $customer->name;
            $this->customerPhone = $customer->phone;
            $this->customerSearch = $customer->name;
            $this->showCustomerDropdown = false;
        }
    }

    // Select medicine with branch-specific stock
    public function selectMedicine($medicineId)
    {
        if (!$this->branchId) {
            session()->flash('error', 'Please select a branch first!');
            return;
        }

        $medicine = Medicine::with(['stocks' => function ($query) {
            $query->where('branch_id', $this->branchId)
                ->where('quantity', '>', 0)
                ->orderBy('expiry_date');
        }])->find($medicineId);

        if (!$medicine) {
            session()->flash('error', 'Medicine not found!');
            return;
        }

        $stock = $medicine->stocks->first();

        if (!$stock) {
            session()->flash('error', 'No stock available for this medicine in selected branch!');
            return;
        }

        $availableStock = $stock->quantity;

        // Check if medicine already exists in current items
        foreach ($this->medicineItems as $index => $item) {
            if ($item['medicine_id'] == $medicine->id && $item['stock_id'] == $stock->id) {
                $newQuantity = $item['quantity'] + 1;
                if ($newQuantity <= $availableStock) {
                    $this->medicineItems[$index]['quantity'] = $newQuantity;
                    $this->calculateTotals();
                    return;
                } else {
                    session()->flash('error', 'Cannot add more. Stock limit reached!');
                    return;
                }
            }
        }

        // Check if medicine was in original items (for stock calculation)
        $originalQuantity = 0;
        foreach ($this->originalMedicineItems as $item) {
            if ($item['medicine_id'] == $medicine->id && $item['stock_id'] == $stock->id) {
                $originalQuantity = $item['original_quantity'];
                break;
            }
        }

        // Calculate available stock including original quantity if this item was in the original sale
        $adjustedStock = $availableStock + $originalQuantity;

        // Add new medicine item
        $this->medicineItems[] = [
            'id' => null, // New item, no sale item ID yet
            'medicine_id' => $medicine->id,
            'medicine_name' => $medicine->name,
            'generic_name' => $medicine->generic_name,
            'stock_id' => $stock->id,
            'batch_number' => $stock->batch_number,
            'expiry_date' => $stock->expiry_date,
            'stock_quantity' => $adjustedStock,
            'quantity' => 1,
            'unit_price' => $stock->selling_price,
            'purchase_price' => $stock->purchase_price,
            'original_quantity' => 0, // New item, wasn't in original sale
        ];

        $this->calculateTotals();
    }

    // Select existing customer
    public function selectCustomer($customerId)
    {
        $customer = Customer::find($customerId);

        if ($customer) {
            $this->customerId = $customer->id;
            $this->customerName = $customer->name;
            $this->customerPhone = $customer->phone;
            $this->customerSearch = $customer->name;
        }
    }

    // Clear customer selection
    public function clearCustomer()
    {
        $this->customerId = null;
        $this->customerName = '';
        $this->customerPhone = '';
        $this->customerSearch = '';
        $this->showCustomerDropdown = false;
    }

    // Create new customer from search
    public function createNewCustomer()
    {
        if (empty($this->customerSearch)) {
            session()->flash('error', 'Please enter customer name!');
            return;
        }

        $this->customerName = $this->customerSearch;
        $this->customerId = null;
        $this->showCustomerDropdown = false;

        session()->flash('message', 'New customer will be created: ' . $this->customerName);
    }

    // Real-time updates for medicine items
    public function updatedMedicineItems($value, $key)
    {
        if (str_contains($key, '.')) {
            [$index, $field] = explode('.', $key);

            if (is_numeric($index) && isset($this->medicineItems[$index])) {
                if (in_array($field, ['quantity', 'unit_price'])) {
                    $this->medicineItems[$index][$field] = floatval($value);

                    if ($field === 'quantity' && isset($this->medicineItems[$index]['stock_quantity'])) {
                        $maxQuantity = $this->medicineItems[$index]['stock_quantity'];
                        if ($value > $maxQuantity) {
                            $this->medicineItems[$index]['quantity'] = $maxQuantity;
                            session()->flash('error', 'Quantity cannot exceed available stock!');
                        }
                    }

                    $this->calculateTotals();
                }
            }
        }
    }

    // Real-time updates
    public function updated($propertyName, $value)
    {
        if (in_array($propertyName, ['discount', 'taxRate'])) {
            $this->{$propertyName} = floatval($value);
            $this->calculateTotals();
        }

        // Show customer dropdown when typing in search
        if ($propertyName === 'customerSearch') {
            if (!empty($value)) {
                $this->showCustomerDropdown = true;
            }
        }
    }

    // Calculate totals in real-time
    public function calculateTotals()
    {
        $this->subTotal = 0;

        foreach ($this->medicineItems as $item) {
            $quantity = floatval($item['quantity'] ?? 0);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $this->subTotal += $quantity * $unitPrice;
        }

        $this->taxAmount = ($this->subTotal * floatval($this->taxRate)) / 100;
        $this->grandTotal = $this->subTotal + $this->taxAmount - floatval($this->discount);

        $this->dispatch('totals-updated', [
            'subTotal' => $this->subTotal,
            'taxAmount' => $this->taxAmount,
            'grandTotal' => $this->grandTotal,
        ]);
    }

    public function addMedicineItem()
    {
        $this->showMedicineDropdown();
    }

    public function removeMedicineItem($index)
    {
        if (isset($this->medicineItems[$index])) {
            unset($this->medicineItems[$index]);
            $this->medicineItems = array_values($this->medicineItems);
            $this->calculateTotals();
        }
    }

    public function updateMedicineItem($index, $field, $value)
    {
        if (isset($this->medicineItems[$index])) {
            $this->medicineItems[$index][$field] = $value;
            $this->calculateTotals();
        }
    }

    public function updateSale()
    {
        $this->validate([
            'branchId' => 'required|exists:branches,id',
            'saleDate' => 'required|date',
            'paymentMethod' => 'required|in:cash,card,mobile_banking,other',
            'medicineItems' => 'required|array|min:1',
            'medicineItems.*.medicine_id' => 'required|exists:medicines,id',
            'medicineItems.*.stock_id' => 'required|exists:stocks,id',
            'medicineItems.*.quantity' => 'required|integer|min:1',
            'medicineItems.*.unit_price' => 'required|numeric|min:0',
            'customerName' => 'required|string|min:2',
            'customerPhone' => 'nullable|string',
            'saleStatus' => 'required|in:pending,completed,cancelled',
        ]);

        try {
            DB::beginTransaction();

            // Calculate stock adjustments
            $this->adjustStock();

            // Create or find customer
            $customerData = [
                'name' => $this->customerName,
                'phone' => $this->customerPhone,
            ];

            if ($this->customerId) {
                $customer = Customer::find($this->customerId);
            } else {
                $customer = Customer::where('phone', $this->customerPhone)->first();

                if (!$customer && $this->customerPhone) {
                    $customerId = 'CUST-'.str_pad(Customer::count() + 1, 6, '0', STR_PAD_LEFT);
                    $customer = Customer::create(array_merge($customerData, [
                        'customer_id' => $customerId,
                    ]));
                } elseif (!$this->customerPhone) {
                    $customer = null;
                }
            }

            // Calculate profit
            $totalProfit = 0;
            foreach ($this->medicineItems as $item) {
                $purchasePrice = $item['purchase_price'] ?? 0;
                $sellingPrice = $item['unit_price'] ?? 0;
                $quantity = $item['quantity'] ?? 0;
                $profitPerItem = ($sellingPrice - $purchasePrice) * $quantity;
                $totalProfit += $profitPerItem;
            }

            // Update sale
            $this->sale->update([
                'branch_id' => $this->branchId,
                'customer_id' => $customer->id ?? null,
                'sale_date' => $this->saleDate,
                'sub_total' => $this->subTotal,
                'discount' => $this->discount,
                'tax_amount' => $this->taxAmount,
                'grand_total' => $this->grandTotal,
                'payment_method' => $this->paymentMethod,
                'status' => $this->saleStatus,
                'customer_name' => $this->customerName,
                'customer_phone' => $this->customerPhone,
                'notes' => $this->notes,
                'total_profit' => $totalProfit,
            ]);

            // Update sale items
            $existingItemIds = [];
            foreach ($this->medicineItems as $item) {
                if (isset($item['id'])) {
                    // Update existing item
                    $saleItem = SaleItem::find($item['id']);
                    if ($saleItem) {
                        $saleItem->update([
                            'quantity' => $item['quantity'],
                            'unit_price' => $item['unit_price'],
                            'total_amount' => $item['quantity'] * $item['unit_price'],
                            'profit' => ($item['unit_price'] - $item['purchase_price']) * $item['quantity'],
                        ]);
                        $existingItemIds[] = $saleItem->id;
                    }
                } else {
                    // Create new item
                    $saleItem = SaleItem::create([
                        'sale_id' => $this->sale->id,
                        'medicine_id' => $item['medicine_id'],
                        'stock_id' => $item['stock_id'],
                        'batch_number' => $item['batch_number'],
                        'expiry_date' => $item['expiry_date'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'purchase_price' => $item['purchase_price'],
                        'total_amount' => $item['quantity'] * $item['unit_price'],
                        'profit' => ($item['unit_price'] - $item['purchase_price']) * $item['quantity'],
                    ]);
                    $existingItemIds[] = $saleItem->id;
                }
            }

            // Delete removed items
            SaleItem::where('sale_id', $this->sale->id)
                ->whereNotIn('id', $existingItemIds)
                ->delete();

            // Update customer loyalty points
            if ($customer) {
                // Recalculate total spent
                $customer->total_spent = $customer->sales()->where('status', 'completed')->sum('grand_total');
                $customer->save();
            }

            DB::commit();

            session()->flash('message', 'Sale updated successfully!');

            return redirect()->route('admin.sales.view', $this->sale->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error updating sale: ' . $e->getMessage());
        }
    }

    private function adjustStock()
    {
        // Restore original stock first
        foreach ($this->originalMedicineItems as $item) {
            $stock = Stock::find($item['stock_id']);
            if ($stock) {
                $stock->increment('quantity', $item['original_quantity']);
                Medicine::where('id', $item['medicine_id'])->decrement('total_sold', $item['original_quantity']);
            }
        }

        // Deduct new quantities
        foreach ($this->medicineItems as $item) {
            $stock = Stock::find($item['stock_id']);
            if ($stock) {
                if ($stock->quantity < $item['quantity']) {
                    throw new \Exception('Insufficient stock for ' . $item['medicine_name'] . '. Available: ' . $stock->quantity);
                }
                $stock->decrement('quantity', $item['quantity']);
                Medicine::where('id', $item['medicine_id'])->increment('total_sold', $item['quantity']);
            }
        }
    }

    public function cancelSale()
    {
        try {
            DB::beginTransaction();

            // Restore stock
            foreach ($this->originalMedicineItems as $item) {
                $stock = Stock::find($item['stock_id']);
                if ($stock) {
                    $stock->increment('quantity', $item['original_quantity']);
                    Medicine::where('id', $item['medicine_id'])->decrement('total_sold', $item['original_quantity']);
                }
            }

            // Update sale status
            $this->sale->update([
                'status' => 'cancelled',
                'notes' => $this->sale->notes . "\n\n[Cancelled on: " . now()->format('Y-m-d H:i:s') . "]",
            ]);

            DB::commit();

            session()->flash('message', 'Sale cancelled successfully! Stock has been restored.');
            return redirect()->route('admin.sales.view', $this->sale->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error cancelling sale: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        // Reload original data
        $this->mount($this->sale->id);
        $this->dispatch('form-reset');
    }

    public function render()
    {
        $branches = Branch::where('is_active', true)->get();

        return view('livewire.backend.sale.edit-component', [
            'branches' => $branches,
            'filteredMedicines' => $this->filteredMedicines,
            'filteredCustomers' => $this->filteredCustomers,
        ])->layout('layouts.backend.app');
    }
}
