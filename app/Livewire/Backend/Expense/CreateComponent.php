<?php

namespace App\Livewire\Backend\Expense;

use Livewire\Component;

class CreateComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.expense.create-component')->layout('layouts.backend.app');
    }
}
