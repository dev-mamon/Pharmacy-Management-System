<?php

namespace App\Livewire\Backend\Customer;

use Livewire\Component;

class EditComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.customer.edit-component')->layout('layouts.backend.app');
    }
}
