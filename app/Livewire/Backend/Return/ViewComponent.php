<?php

namespace App\Livewire\Backend\Return;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.return.view-component')->layout('layouts.backend.app')->layout('layouts.backend.app');
    }
}
