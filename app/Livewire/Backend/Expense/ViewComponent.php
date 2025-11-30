<?php

namespace App\Livewire\Backend\Expense;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.expense.view-component')->layout('layouts.backend.app');
    }
}
