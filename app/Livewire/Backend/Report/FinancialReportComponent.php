<?php

namespace App\Livewire\Backend\Report;

use Livewire\Component;

class FinancialReportComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.report.financial-report-component')->layout('layouts.backend.app');
    }
}
