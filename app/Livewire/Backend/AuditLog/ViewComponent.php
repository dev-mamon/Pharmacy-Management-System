<?php

namespace App\Livewire\Backend\AuditLog;

use Livewire\Component;

class ViewComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.audit-log.view-component')->layout('layouts.backend.app');
    }
}
