<?php

namespace App\Livewire\Backend\Stock;

use Livewire\Component;
use App\Models\Stock;
use App\Models\Medicine;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class EditComponent extends Component
{
    public Stock $stock;

    public $medicine_id;
    public $branch_id;
    public $batch_number;
    public $expiry_date;
    public $purchase_price;
    public $selling_price;
    public $quantity;
    public $min_stock_level;
    public $reorder_level;

    protected function rules()
    {
        return [
            'medicine_id' => 'required|exists:medicines,id',
            'branch_id' => 'required|exists:branches,id',
            'batch_number' => 'required|string|max:100|unique:stocks,batch_number,' . $this->stock->id . ',id,medicine_id,' . $this->medicine_id . ',branch_id,' . $this->branch_id,
            'expiry_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0'
        ];
    }

    protected $messages = [
        'batch_number.unique' => 'This batch number already exists for the selected medicine and branch.'
    ];

    public function mount(Stock $stock)
    {
        $this->stock = $stock;
        $this->medicine_id = $stock->medicine_id;
        $this->branch_id = $stock->branch_id;
        $this->batch_number = $stock->batch_number;
        $this->expiry_date = $stock->expiry_date->format('Y-m-d');
        $this->purchase_price = $stock->purchase_price;
        $this->selling_price = $stock->selling_price;
        $this->quantity = $stock->quantity;
        $this->min_stock_level = $stock->min_stock_level;
        $this->reorder_level = $stock->reorder_level;
    }

    public function update()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $this->stock->update([
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

                session()->flash('success', 'Stock updated successfully!');
                $this->redirect(route('admin.stocks.index'), navigate: true);
            });
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update stock. Please try again.');
        }
    }

    public function render()
    {
        $medicines = Medicine::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();

        return view('livewire.backend.stock.edit-component', [
            'medicines' => $medicines,
            'branches' => $branches
        ])->layout('layouts.backend.app');
    }
}
