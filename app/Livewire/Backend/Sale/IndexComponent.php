<?php

namespace App\Livewire\Backend\Sale;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.sale.index-component')->layout('layouts.backend.app');
    }
}
