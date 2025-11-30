<?php

namespace App\Livewire\Backend\Stock;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.stock.create-component')->layout('layouts.backend.app');
    }
}
