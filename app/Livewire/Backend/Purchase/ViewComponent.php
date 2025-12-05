<?php

namespace App\Livewire\Backend\Purchase;

use App\Models\Purchase;
use Livewire\Component;

class ViewComponent extends Component
{
    public $purchase;

    public function mount($id)
    {
        $this->purchase = Purchase::with([
            'supplier',
            'branch',
            'user',
            'purchaseItems.medicine'
        ])->findOrFail($id);
    }

    public function updateStatus($status)
    {
        $this->validate([
            'status' => 'in:pending,completed,cancelled',
        ]);

        if ($status === 'completed' && $this->purchase->status !== 'completed') {
            // Update stock when completing purchase
            foreach ($this->purchase->purchaseItems as $item) {
                \App\Models\Stock::updateOrCreate(
                    [
                        'medicine_id' => $item->medicine_id,
                        'branch_id' => $this->purchase->branch_id,
                        'batch_number' => $item->batch_number,
                    ],
                    [
                        'quantity' => \DB::raw("quantity + {$item->quantity}"),
                        'purchase_price' => $item->unit_price,
                        'selling_price' => $item->unit_price * 1.3,
                        'expiry_date' => $item->expiry_date,
                        'reorder_level' => 10,
                    ]
                );
            }
        }

        $this->purchase->update(['status' => $status]);
        $this->purchase->refresh();

        session()->flash('message', 'Purchase status updated successfully.');
    }

    public function render()
    {
        return view('livewire.backend.purchase.view-component')->layout('layouts.backend.app');
    }
}
