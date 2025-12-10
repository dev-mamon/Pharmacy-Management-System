<?php

namespace App\Livewire\Backend\StockTransfer;

use Livewire\Component;
use App\Models\StockTransfer;
use Illuminate\Support\Facades\DB;

class ViewComponent extends Component
{
    public $transfer;
    public $transferItems;

    public function mount($id)
    {
        $this->transfer = StockTransfer::with([
            'fromBranch',
            'toBranch',
            'user',
            'transferItems.medicine'
        ])->findOrFail($id);

        $this->transferItems = $this->transfer->transferItems;
    }

    public function updateStatus($status)
    {
        $validStatuses = ['pending', 'approved', 'rejected', 'completed'];

        if (!in_array($status, $validStatuses)) {
            session()->flash('error', 'Invalid status.');
            return;
        }

        DB::beginTransaction();

        try {
            $oldStatus = $this->transfer->status;
            $this->transfer->update(['status' => $status]);

            // Handle status-specific actions
            if ($status === 'completed' && $oldStatus !== 'completed') {
                $this->completeTransfer();
            }

            DB::commit();

            session()->flash('success', 'Transfer status updated to ' . ucfirst($status));
            $this->transfer->refresh();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    protected function completeTransfer()
    {
        // Additional logic when transfer is completed
        // For example, create stock movement logs, notifications, etc.

        // For now, just update the status
        return true;
    }

    public function deleteTransfer()
    {
        DB::beginTransaction();

        try {
            // Restore stock for all items
            foreach ($this->transferItems as $item) {
                // Restore stock to source branch
                $stock = \App\Models\Stock::where('branch_id', $this->transfer->from_branch_id)
                    ->where('medicine_id', $item->medicine_id)
                    ->first();

                if ($stock) {
                    $stock->increment('quantity', $item->quantity);
                }
            }

            // Delete the transfer
            $this->transfer->delete();

            DB::commit();

            session()->flash('success', 'Transfer deleted successfully.');
            return redirect()->route('admin.stock-transfers.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to delete transfer: ' . $e->getMessage());
        }
    }

    public function getTotalQuantity()
    {
        return $this->transferItems->sum('quantity');
    }

    public function render()
    {
        return view('livewire.backend.stock-transfer.view-component', [
            'transfer' => $this->transfer,
            'transferItems' => $this->transferItems,
            'totalQuantity' => $this->getTotalQuantity(),
        ])->layout('layouts.backend.app');
    }
}
