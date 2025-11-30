<?php

namespace App\Livewire\Backend\Stock;

use Livewire\Component;

class EditComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.stock.edit-component')->layout('layouts.backend.app');
    }
}
