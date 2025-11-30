<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.user.view-component')->layout('layouts.backend.app');
    }
}
