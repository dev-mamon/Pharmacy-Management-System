<?php

namespace App\Livewire\Backend\Stock;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.stock.view-component')->layout('layouts.backend.app');
    }
}
