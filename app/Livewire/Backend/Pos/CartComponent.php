<?php

namespace App\Livewire\Backend\Pos;

use Livewire\Component;

class CartComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.pos.cart-component')->layout('layouts.backend.app');
    }
}
