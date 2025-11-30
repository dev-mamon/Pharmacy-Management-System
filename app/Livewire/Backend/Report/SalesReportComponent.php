<?php

namespace App\Livewire\Backend\Report;

use Livewire\Component;

class SalesReportComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.report.sales-report-component')->layout('layouts.backend.app');
    }
}
