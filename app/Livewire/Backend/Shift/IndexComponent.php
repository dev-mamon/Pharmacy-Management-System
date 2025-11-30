<?php

namespace App\Livewire\Backend\Shift;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.shift.index-component')->layout('layouts.backend.app');
    }
}
