<?php

namespace App\Livewire\Backend\Supplier;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.supplier.view-component')->layout('layouts.backend.app');
    }
}
