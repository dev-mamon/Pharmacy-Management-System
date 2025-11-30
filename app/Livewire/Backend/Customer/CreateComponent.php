<?php

namespace App\Livewire\Backend\Customer;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.customer.create-component')->layout('layouts.backend.app');
    }
}
