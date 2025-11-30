<?php

namespace App\Livewire\Backend\Prescription;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.prescription.create-component')->layout('layouts.backend.app');
    }
}
