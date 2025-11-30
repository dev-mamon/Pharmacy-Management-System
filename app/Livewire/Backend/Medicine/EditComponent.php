<?php

namespace App\Livewire\Backend\Medicine;

use Livewire\Component;

class EditComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.medicine.edit-component')->layout('layouts.backend.app');
    }
}
