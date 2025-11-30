<?php

namespace App\Livewire\Backend\Customer;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.customer.view-component')->layout('layouts.backend.app');
    }
}
