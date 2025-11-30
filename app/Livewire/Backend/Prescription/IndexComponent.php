<?php

namespace App\Livewire\Backend\Prescription;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.prescription.index-component')->layout('layouts.backend.app');
    }
}
