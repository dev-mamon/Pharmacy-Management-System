<?php

namespace App\Livewire\Backend\Alert;

use Livewire\Component;

class LowStockComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.alert.low-stock-component')->layout('layouts.backend.app');
    }
}
