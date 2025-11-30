<?php

namespace App\Livewire\Backend\Pos;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.pos.index-component')->layout('layouts.backend.app');
    }
}
