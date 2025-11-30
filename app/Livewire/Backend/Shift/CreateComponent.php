<?php

namespace App\Livewire\Backend\Shift;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.shift.create-component')->layout('layouts.backend.app');
    }
}
