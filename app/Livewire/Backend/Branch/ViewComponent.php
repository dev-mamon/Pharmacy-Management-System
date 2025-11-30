<?php

namespace App\Livewire\Backend\Branch;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.branch.view-component')->layout('layouts.backend.app');
    }
}
