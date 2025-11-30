<?php

namespace App\Livewire\Backend\Report;

use Livewire\Component;

class InventoryReportComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.report.inventory-report-component')->layout('layouts.backend.app');
    }
}
