<?php

namespace App\Livewire\Backend\Setting;

use Livewire\Component;

class PaymentComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.setting.payment-component')->layout('layouts.backend.app');
    }
}
