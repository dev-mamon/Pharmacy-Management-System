<?php

namespace App\Livewire\Backend\StockTransfer;

use Livewire\Component;

class EditComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.stock-transfer.edit-component')->layout('layouts.backend.app');
    }
}
