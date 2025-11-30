<?php

namespace App\Livewire\Backend\Category;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.category.create-component')->layout('layouts.backend.app');
    }
}
