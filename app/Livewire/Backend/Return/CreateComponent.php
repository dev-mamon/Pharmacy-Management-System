<?php

namespace App\Livewire\Backend\Return;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.return.create-component')->layout('layouts.backend.app');
    }
}
