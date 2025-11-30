<?php

namespace App\Livewire\Backend\Loyalty;

use Livewire\Component;

class TransactionComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.loyalty.transaction-component')->layout('layouts.backend.app');
    }
}
