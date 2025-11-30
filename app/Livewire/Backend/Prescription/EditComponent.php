<?php

namespace App\Livewire\Backend\Prescription;

use Livewire\Component;

class EditComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.prescription.edit-component')->layout('layouts.backend.app');
    }
}
