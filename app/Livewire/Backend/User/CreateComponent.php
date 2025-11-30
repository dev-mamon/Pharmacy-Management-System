<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.user.create-component')->layout('layouts.backend.app');
    }
}
