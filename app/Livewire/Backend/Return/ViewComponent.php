<?php

namespace App\Livewire\Backend\Return;

use App\Models\SalesReturn;
use Livewire\Component;

class ViewComponent extends Component
{
    public $return;

    public $returnId;

    public function mount($id)
    {
        $this->returnId = $id;
        $this->loadReturn();
    }

    public function loadReturn()
    {
        $this->return = SalesReturn::with([
            'sale',
            'branch',
            'customer',
            'user',
            'items.saleItem.medicine',
            'items.medicine',
        ])->findOrFail($this->returnId);
    }

    public function render()
    {
        return view('livewire.backend.return.view-component', [
            'return' => $this->return,
        ])->layout('layouts.backend.app');
    }
}
