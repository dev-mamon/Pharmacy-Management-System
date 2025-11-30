<?php

namespace App\Livewire\Backend\Branch;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.branch.create-component')->layout('layouts.backend.app');
    }
}
