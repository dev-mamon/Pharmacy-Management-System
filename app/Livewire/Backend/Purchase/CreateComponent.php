<?php

namespace App\Livewire\Backend\Purchase;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.purchase.create-component')->layout('layouts.backend.app');
    }
}
