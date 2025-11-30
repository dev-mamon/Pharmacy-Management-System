<?php

namespace App\Livewire\Backend\Invoice;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.invoice.view-component')->layout('layouts.backend.app');
    }
}
