<?php

namespace App\Livewire\Backend\Medicine;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.medicine.view-component')->layout('layouts.backend.app');
    }
}
