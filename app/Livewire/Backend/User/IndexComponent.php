<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.user.index-component')->layout('layouts.backend.app');
    }
}
