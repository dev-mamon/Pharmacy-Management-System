<?php

namespace App\Livewire\Backend\Shift;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.shift.view-component')->layout('layouts.backend.app');
    }
}
