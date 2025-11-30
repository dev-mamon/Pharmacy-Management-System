<?php

namespace App\Livewire\Backend\Prescription;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.prescription.view-component')->layout('layouts.backend.app');
    }
}
