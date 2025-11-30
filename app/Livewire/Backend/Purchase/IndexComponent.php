<?php

namespace App\Livewire\Backend\Purchase;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.purchase.index-component')->layout('layouts.backend.app');
    }
}
