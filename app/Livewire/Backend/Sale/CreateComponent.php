<?php

namespace App\Livewire\Backend\Sale;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateComponent extends Component
{
    public $medicineSearch = '';

    public $dropdownSearch = '';

    public $customerSearch = '';

    public $medicineItems = [];

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

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->saleDate = now()->format('Y-m-d');
        $this->branchId = auth()->user()->branch_id ?? null;
        $this->taxRate = 0;
    }

    public function updatedBranchId($value)
    {
        $this->medicineItems = [];
        $this->medicineSearch = '';
        $this->dropdownSearch = '';
        $this->showMedicineDropdown = false;
        $this->calculateTotals();
        $this->dispatch('branch-changed');
    }

    // Get filtered medicines for dropdown with search
    public function getFilteredMedicinesProperty()
    {
        if (! $this->branchId) {
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
                $q->where('name', 'like', '%'.$this->dropdownSearch.'%')
                    ->orWhere('generic_name', 'like', '%'.$this->dropdownSearch.'%')
                    ->orWhere('brand_name', 'like', '%'.$this->dropdownSearch.'%');
            });
        }

        return $query->get()
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

    // Get filtered customers for dropdown with search
    public function getFilteredCustomersProperty()
    {
        if (empty($this->customerSearch)) {
            return collect();
        }

        return Customer::where('is_active', true)
            ->where(function ($query) {
                $query->where('name', 'like', '%'.$this->customerSearch.'%')
                    ->orWhere('phone', 'like', '%'.$this->customerSearch.'%')
                    ->orWhere('customer_id', 'like', '%'.$this->customerSearch.'%');
            })
            ->limit(15)
            ->get();
    }

    // Show medicine dropdown
    public function showMedicineDropdown()
    {
        if (! $this->branchId) {
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
        // Keep dropdown open after selection
        $this->dropdownSearch = '';
    }

    // Select customer from dropdown
    public function selectCustomerFromDropdown($customerId)
    {
        $this->selectCustomer($customerId);
        // Keep dropdown open after selection
        $this->customerSearch = '';
    }

    // Select medicine with branch-specific stock
    public function selectMedicine($medicineId)
    {
        if (! $this->branchId) {
            session()->flash('error', 'Please select a branch first!');

            return;
        }

        $medicine = Medicine::with(['stocks' => function ($query) {
            $query->where('branch_id', $this->branchId)
                ->where('quantity', '>', 0)
                ->orderBy('expiry_date');
        }])->find($medicineId);

        if (! $medicine) {
            session()->flash('error', 'Medicine not found!');

            return;
        }

        $stock = $medicine->stocks->first();

        if (! $stock) {
            session()->flash('error', 'No stock available for this medicine in selected branch!');

            return;
        }

        $availableStock = $stock->quantity;
        $sellingPrice = $stock->selling_price;

        if ($availableStock <= 0) {
            session()->flash('error', 'No stock available for this medicine!');

            return;
        }

        // Check if medicine already exists in items
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

        // Add new medicine item
        $this->medicineItems[] = [
            'medicine_id' => $medicine->id,
            'medicine_name' => $medicine->name,
            'generic_name' => $medicine->generic_name,
            'stock_id' => $stock->id,
            'batch_number' => $stock->batch_number,
            'expiry_date' => $stock->expiry_date,
            'stock_quantity' => $availableStock,
            'quantity' => 1,
            'unit_price' => $sellingPrice,
            'purchase_price' => $stock->purchase_price,
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
            $this->customerSearch = $customer->name; // Keep search term
            $this->showCustomerDropdown = false; // Close dropdown after selection
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

    // Real-time updates for discount and tax
    public function updated($propertyName, $value)
    {
        if (in_array($propertyName, ['discount', 'taxRate'])) {
            $this->{$propertyName} = floatval($value);
            $this->calculateTotals();
        }

        // Show dropdown when typing in customer search
        if ($propertyName === 'customerSearch' && ! empty($value)) {
            $this->showCustomerDropdown = true;
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

    public function saveDraft()
    {
        $this->createSale('pending');
    }

    public function createSale($status = 'completed')
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
        ]);

        try {
            DB::beginTransaction();

            // Create or find customer
            $customerData = [
                'name' => $this->customerName,
                'phone' => $this->customerPhone,
            ];

            if ($this->customerId) {
                $customer = Customer::find($this->customerId);
            } else {
                $customer = Customer::where('phone', $this->customerPhone)->first();

                if (! $customer && $this->customerPhone) {
                    $customerId = 'CUST-'.str_pad(Customer::count() + 1, 6, '0', STR_PAD_LEFT);

                    $customer = Customer::create(array_merge($customerData, [
                        'customer_id' => $customerId,
                    ]));
                } elseif (! $this->customerPhone) {
                    $customer = null;
                }
            }

            // Generate invoice number
            $invoiceNumber = 'INV-'.date('Ymd').'-'.str_pad(Sale::count() + 1, 4, '0', STR_PAD_LEFT);

            // Calculate profit
            $totalProfit = 0;
            foreach ($this->medicineItems as $item) {
                $purchasePrice = $item['purchase_price'] ?? 0;
                $sellingPrice = $item['unit_price'] ?? 0;
                $quantity = $item['quantity'] ?? 0;
                $profitPerItem = ($sellingPrice - $purchasePrice) * $quantity;
                $totalProfit += $profitPerItem;
            }

            // Create sale
            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'branch_id' => $this->branchId,
                'customer_id' => $customer->id ?? null,
                'user_id' => 1,
                'sale_date' => $this->saleDate,
                'sub_total' => $this->subTotal,
                'discount' => $this->discount,
                'tax_amount' => $this->taxAmount,
                'grand_total' => $this->grandTotal,
                'payment_method' => $this->paymentMethod,
                'status' => $status,
                'customer_name' => $this->customerName,
                'customer_phone' => $this->customerPhone,
                'notes' => $this->notes,
                'total_profit' => $totalProfit,
            ]);

            // Create sale items and update stock
            foreach ($this->medicineItems as $item) {
                $stock = Stock::find($item['stock_id']);

                if (! $stock) {
                    throw new Exception('Stock not found for medicine: '.$item['medicine_name']);
                }

                if ($stock->quantity < $item['quantity']) {
                    throw new Exception('Insufficient stock for '.$item['medicine_name'].'. Available: '.$stock->quantity);
                }

                $itemProfit = ($item['unit_price'] - $item['purchase_price']) * $item['quantity'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $item['medicine_id'],
                    'stock_id' => $item['stock_id'],
                    'batch_number' => $item['batch_number'],
                    'expiry_date' => $item['expiry_date'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'purchase_price' => $item['purchase_price'],
                    'total_amount' => $item['quantity'] * $item['unit_price'],
                    'profit' => $itemProfit,
                ]);

                $stock->decrement('quantity', $item['quantity']);
                Medicine::where('id', $item['medicine_id'])->increment('total_sold', $item['quantity']);
            }

            // Update customer loyalty points
            if ($customer) {
                $customer->increment('total_spent', $this->grandTotal);
                $loyaltyPoints = floor($this->grandTotal / 100);
                if ($loyaltyPoints > 0) {
                    $customer->increment('loyalty_points', $loyaltyPoints);
                }
            }

            DB::commit();

            session()->flash('message', 'Sale created successfully! Invoice #'.$invoiceNumber);

            return redirect()->route('admin.sales.view', $sale->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error creating sale: '.$e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'medicineItems',
            'customerId',
            'customerName',
            'customerPhone',
            'customerSearch',
            'notes',
            'discount',
            'medicineSearch',
            'dropdownSearch',
            'subTotal',
            'taxAmount',
            'grandTotal',
            'showMedicineDropdown',
            'showCustomerDropdown',
        ]);
        $this->taxRate = 0;
        $this->dispatch('form-reset');
    }

    public function render()
    {
        $branches = Branch::where('is_active', true)->get();

        return view('livewire.backend.sale.create-component', [
            'branches' => $branches,
            'filteredMedicines' => $this->filteredMedicines,
            'filteredCustomers' => $this->filteredCustomers,
        ])->layout('layouts.backend.app');
    }
}
