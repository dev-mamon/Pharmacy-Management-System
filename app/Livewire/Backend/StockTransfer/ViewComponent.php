<?php

namespace App\Livewire\Backend\StockTransfer;

use App\Models\StockTransfer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewComponent extends Component
{
    public $transfer;

    public function mount(StockTransfer $transfer)
    {
        $this->transfer = $transfer->load([
            'fromBranch',
            'toBranch',
            'user',
            'items.stock.medicine'
        ]);
    }

    public function approve()
    {
        if ($this->transfer->status !== 'pending') {
            session()->flash('error', 'Only pending transfers can be approved.');
            return;
        }

        $this->transfer->update(['status' => 'approved']);
        session()->flash('success', 'Transfer approved successfully.');
        $this->redirect(route('stock-transfers.view', $this->transfer->id), navigate: true);
    }

    public function reject()
    {
        if ($this->transfer->status !== 'pending') {
            session()->flash('error', 'Only pending transfers can be rejected.');
            return;
        }

        $this->transfer->update(['status' => 'rejected']);
        session()->flash('success', 'Transfer rejected.');
        $this->redirect(route('stock-transfers.view', $this->transfer->id), navigate: true);
    }

    public function complete()
    {
        if ($this->transfer->status !== 'approved') {
            session()->flash('error', 'Only approved transfers can be completed.');
            return;
        }

        try {
            DB::beginTransaction();

            // Process each item
            foreach ($this->transfer->items as $item) {
                // Deduct from source branch
                $sourceStock = $item->stock;
                if ($sourceStock->quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$item->stock->medicine->name}");
                }
                $sourceStock->decrement('quantity', $item->quantity);

                // Add to destination branch (or create new stock record)
                // This is a simplified version - you might need more complex logic
                $destinationStock = \App\Models\Stock::firstOrCreate([
                    'branch_id' => $this->transfer->to_branch_id,
                    'medicine_id' => $item->stock->medicine_id,
                    'batch_number' => $item->stock->batch_number,
                    'expiry_date' => $item->stock->expiry_date,
                ], [
                    'quantity' => 0,
                    'purchase_price' => $item->stock->purchase_price,
                    'selling_price' => $item->stock->selling_price,
                ]);

                $destinationStock->increment('quantity', $item->quantity);
            }

            $this->transfer->update(['status' => 'completed']);

            DB::commit();

            session()->flash('success', 'Transfer completed successfully.');
            $this->redirect(route('admin.stock-transfers.view', $this->transfer->id), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to complete transfer: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        if ($this->transfer->status !== 'pending') {
            session()->flash('error', 'Only pending transfers can be deleted.');
            return;
        }

        $this->transfer->delete();
        session()->flash('success', 'Transfer deleted successfully.');
        $this->redirect('/admin/stock-transfers', navigate: true);
    }

    public function render()
    {
        return view('livewire.backend.stock-transfer.view-component')->layout('layouts.backend.app');
    }
}
