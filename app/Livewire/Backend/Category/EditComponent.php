<?php

namespace App\Livewire\Backend\Category;

use Livewire\Component;

class EditComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.category.edit-component')->layout('layouts.backend.app');
    }
}
