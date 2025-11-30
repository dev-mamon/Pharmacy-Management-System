<?php

namespace App\Livewire\Backend\Sale;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.sale.view-component')->layout('layouts.backend.app');
    }
}
