<?php

namespace App\Livewire\Backend\StockTransfer;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.stock-transfer.create-component')->layout('layouts.backend.app');
    }
}
