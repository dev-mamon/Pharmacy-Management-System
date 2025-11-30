<?php

namespace App\Livewire\Backend\AuditLog;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.audit-log.index-component')->layout('layouts.backend.app');
    }
}
