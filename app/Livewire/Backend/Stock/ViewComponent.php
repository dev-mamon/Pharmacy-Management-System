<?php

namespace App\Livewire\Backend\Stock;

use Livewire\Component;
use App\Models\Stock;

class ViewComponent extends Component
{
    public Stock $stock;

    public function mount(Stock $stock)
    {
        $this->stock = $stock->load(['medicine', 'branch']);
    }

    public function render()
    {
        return view('livewire.backend.stock.view-component')
            ->layout('layouts.backend.app');
    }
}
