<?php

namespace App\Livewire\Backend\StockTransfer;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.stock-transfer.index-component')->layout('layouts.backend.app');
    }
}
