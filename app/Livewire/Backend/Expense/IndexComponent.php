<?php

namespace App\Livewire\Backend\Expense;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.expense.index-component')->layout('layouts.backend.app');
    }
}
