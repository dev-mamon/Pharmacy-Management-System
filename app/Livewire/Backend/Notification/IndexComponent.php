<?php

namespace App\Livewire\Backend\Notification;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.notification.index-component')->layout('layouts.backend.app');
    }
}
