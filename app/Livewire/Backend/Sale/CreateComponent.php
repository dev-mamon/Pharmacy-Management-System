<?php

namespace App\Livewire\Backend\Sale;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.sale.create-component')->layout('layouts.backend.app');
    }
}
