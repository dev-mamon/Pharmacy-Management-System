<?php

namespace App\Livewire\Backend\Supplier;

use Livewire\Component;

class EditComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.supplier.edit-component')->layout('layouts.backend.app');
    }
}
