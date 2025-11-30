<?php

namespace App\Livewire\Backend\Report;

use Livewire\Component;

class CustomerReportComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.report.customer-report-component')->layout('layouts.backend.app');
    }
}
