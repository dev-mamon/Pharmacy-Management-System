<?php

namespace App\Livewire\Backend\Sale;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class ViewComponent extends Component
{
    public $sale;

    public function mount($id)
    {
        $this->sale = Sale::with(['saleItems.medicine', 'branch', 'user'])->findOrFail($id);
    }

    public function completeSale()
    {
        try {
            $this->sale->update(['status' => 'completed']);
            session()->flash('message', 'Sale marked as completed!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating sale: ' . $e->getMessage());
        }
    }

    public function cancelSale()
    {
        try {
            DB::beginTransaction();

            // Return all items to stock
            foreach ($this->sale->saleItems as $item) {
                $stock = Stock::find($item->stock_id);
                if ($stock) {
                    $stock->increment('quantity', $item->quantity);
                }
            }

            // Update sale status
            $this->sale->update(['status' => 'cancelled']);

            DB::commit();
            session()->flash('message', 'Sale cancelled and stock returned successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error cancelling sale: ' . $e->getMessage());
        }
    }

    public function printInvoice()
    {
        $this->dispatch('print-invoice', saleId: $this->sale->id);
    }

    public function render()
    {
        return view('livewire.backend.sale.view-component')
            ->layout('layouts.backend.app');
    }
}
