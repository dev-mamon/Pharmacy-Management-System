<?php

namespace App\Livewire\Backend\Invoice;

use Livewire\Component;

class PrintComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.invoice.print-component')->layout('layouts.backend.app');
    }
}
