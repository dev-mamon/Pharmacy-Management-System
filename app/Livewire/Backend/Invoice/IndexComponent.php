<?php

namespace App\Livewire\Backend\Invoice;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.invoice.index-component')->layout('layouts.backend.app');
    }
}
