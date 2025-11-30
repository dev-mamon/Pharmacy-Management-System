<?php

namespace App\Livewire\Backend\Expense;

use Livewire\Component;

class EditComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.expense.edit-component')->layout('layouts.backend.app');
    }
}
