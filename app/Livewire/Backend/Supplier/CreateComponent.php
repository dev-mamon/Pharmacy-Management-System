<?php

namespace App\Livewire\Backend\Supplier;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.supplier.create-component')->layout('layouts.backend.app');
    }
}
