<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;

class EditComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.user.edit-component')->layout('layouts.backend.app');
    }
}
