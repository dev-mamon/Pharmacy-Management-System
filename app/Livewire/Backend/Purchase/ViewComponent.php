<?php

namespace App\Livewire\Backend\Purchase;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.purchase.view-component')->layout('layouts.backend.app');
    }
}
