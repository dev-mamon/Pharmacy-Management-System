<?php

namespace App\Livewire\Backend\Sale;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditComponent extends Component
{
    public $sale;

    public $customerName;

    public $customerPhone;

    public $notes;

    public $saleDate;

    public $paymentMethod;

    public $status;

    public $discount;

    public function mount($id)
    {
        $this->sale = Sale::with('saleItems.medicine')->findOrFail($id);
        $this->customerName = $this->sale->customer_name;
        $this->customerPhone = $this->sale->customer_phone;
        $this->notes = $this->sale->notes;
        $this->saleDate = $this->sale->sale_date->format('Y-m-d');
        $this->paymentMethod = $this->sale->payment_method;
        $this->status = $this->sale->status;
        $this->discount = $this->sale->discount;
    }

    public function updateSale()
    {
        $this->validate([
            'customerName' => 'nullable|string|max:255',
            'customerPhone' => 'nullable|string|max:20',
            'saleDate' => 'required|date',
            'paymentMethod' => 'required|in:cash,card,mobile_banking,other',
            'status' => 'required|in:completed,pending,cancelled',
            'discount' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $this->sale->update([
                'customer_name' => $this->customerName,
                'customer_phone' => $this->customerPhone,
                'notes' => $this->notes,
                'sale_date' => $this->saleDate,
                'payment_method' => $this->paymentMethod,
                'status' => $this->status,
                'discount' => $this->discount,
            ]);

            // Recalculate totals if discount changed
            if ($this->discount != $this->sale->discount) {
                $this->sale->grand_total = $this->sale->sub_total + $this->sale->tax_amount - $this->discount;
                $this->sale->save();
            }

            DB::commit();

            session()->flash('message', 'Sale updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error updating sale: '.$e->getMessage());
        }
    }

    public function removeItem($itemId)
    {
        try {
            DB::beginTransaction();

            $item = SaleItem::findOrFail($itemId);

            // Return stock
            $stock = Stock::find($item->stock_id);
            if ($stock) {
                $stock->increment('quantity', $item->quantity);
            }

            // Delete item
            $item->delete();

            // Recalculate sale totals
            $this->sale->refresh();
            $this->sale->sub_total = $this->sale->saleItems->sum('total_amount');
            $this->sale->grand_total = $this->sale->sub_total + $this->sale->tax_amount - $this->sale->discount;
            $this->sale->save();

            DB::commit();

            session()->flash('message', 'Item removed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error removing item: '.$e->getMessage());
        }
    }

    public function completeSale()
    {
        $this->status = 'completed';
        $this->updateSale();
    }

    public function cancelSale()
    {
        $this->status = 'cancelled';
        $this->updateSale();

        // Return all items to stock
        try {
            DB::beginTransaction();

            foreach ($this->sale->saleItems as $item) {
                $stock = Stock::find($item->stock_id);
                if ($stock) {
                    $stock->increment('quantity', $item->quantity);
                }
            }

            DB::commit();
            session()->flash('message', 'Sale cancelled and stock returned successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error cancelling sale: '.$e->getMessage());
        }
    }

    public function printInvoice()
    {
        // Implement print functionality
        $this->dispatch('print-invoice', saleId: $this->sale->id);
    }

    public function render()
    {
        return view('livewire.backend.sale.edit-component')
            ->layout('layouts.backend.app');
    }
}
