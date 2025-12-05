<?php

namespace App\Livewire\Backend\Stock;

use Livewire\Component;
use App\Models\Stock;
use App\Models\Medicine;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class CreateComponent extends Component
{
    public $medicine_id;
    public $branch_id;
    public $batch_number;
    public $expiry_date;
    public $purchase_price;
    public $selling_price;
    public $quantity;
    public $min_stock_level = 10;
    public $reorder_level = 20;

    protected $rules = [
        'medicine_id' => 'required|exists:medicines,id',
        'branch_id' => 'required|exists:branches,id',
        'batch_number' => 'required|string|max:100',
        'expiry_date' => 'required|date|after:today',
        'purchase_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'min_stock_level' => 'required|integer|min:0',
        'reorder_level' => 'required|integer|min:0'
    ];

    protected $messages = [
        'medicine_id.required' => 'Please select a medicine.',
        'branch_id.required' => 'Please select a branch.',
        'batch_number.required' => 'Batch number is required.',
        'expiry_date.required' => 'Expiry date is required.',
        'expiry_date.after' => 'Expiry date must be in the future.',
        'purchase_price.required' => 'Purchase price is required.',
        'selling_price.required' => 'Selling price is required.',
        'quantity.required' => 'Quantity is required.'
    ];

    public function mount()
    {
        // Initialize with today's date
        $this->expiry_date = now()->addMonths(6)->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        // Check for unique batch number per medicine and branch
        $exists = Stock::where('medicine_id', $this->medicine_id)
            ->where('branch_id', $this->branch_id)
            ->where('batch_number', $this->batch_number)
            ->exists();

        if ($exists) {
            $this->addError('batch_number', 'This batch number already exists for the selected medicine and branch.');
            return;
        }

        try {
            DB::transaction(function () {
                Stock::create([
                    'medicine_id' => $this->medicine_id,
                    'branch_id' => $this->branch_id,
                    'batch_number' => $this->batch_number,
                    'expiry_date' => $this->expiry_date,
                    'purchase_price' => $this->purchase_price,
                    'selling_price' => $this->selling_price,
                    'quantity' => $this->quantity,
                    'min_stock_level' => $this->min_stock_level,
                    'reorder_level' => $this->reorder_level
                ]);

                session()->flash('success', 'Stock created successfully!');
                $this->redirect(route('admin.stocks.index'), navigate: true);
            });
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create stock. Please try again.');
        }
    }

    public function render()
    {
        $medicines = Medicine::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();

        return view('livewire.backend.stock.create-component', [
            'medicines' => $medicines,
            'branches' => $branches
        ])->layout('layouts.backend.app');
    }
}
