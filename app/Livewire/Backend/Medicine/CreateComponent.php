<?php

namespace App\Livewire\Backend\Medicine;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.medicine.create-component')->layout('layouts.backend.app');
    }
}
