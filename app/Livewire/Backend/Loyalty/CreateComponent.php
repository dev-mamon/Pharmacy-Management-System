<?php

namespace App\Livewire\Backend\Loyalty;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.loyalty.create-component')->layout('layouts.backend.app');
    }
}
