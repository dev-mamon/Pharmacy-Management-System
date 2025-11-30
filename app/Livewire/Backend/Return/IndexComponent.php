<?php

namespace App\Livewire\Backend\Return;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.return.index-component')->layout('layouts.backend.app');
    }
}
