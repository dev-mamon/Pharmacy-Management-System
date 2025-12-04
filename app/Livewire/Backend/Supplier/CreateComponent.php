<?php

namespace App\Livewire\Backend\Supplier;

use Livewire\Component;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateComponent extends Component
{
    public $name;
    public $contact_person;
    public $email;
    public $phone;
    public $address;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'contact_person' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255|unique:suppliers,email',
        'phone' => 'required|string|max:20|unique:suppliers,phone',
        'address' => 'nullable|string',
        'is_active' => 'boolean'
    ];

    protected $messages = [
        'name.required' => 'Supplier name is required.',
        'phone.required' => 'Phone number is required.',
        'phone.unique' => 'This phone number is already registered.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.'
    ];

    public function mount()
    {
        // Initialize component if needed
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $supplier = Supplier::create([
                    'name' => $this->name,
                    'contact_person' => $this->contact_person,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'is_active' => $this->is_active
                ]);

                // Dispatch event for notifications
                $this->dispatch('supplier-created', [
                    'title' => 'Supplier Created',
                    'message' => "Supplier '{$this->name}' has been created successfully.",
                    'type' => 'success'
                ]);

                // Redirect to suppliers list
                $this->redirect(route('admin.suppliers.index'), navigate: true);
            });
        } catch (\Exception $e) {
            Log::error('Failed to create supplier: ' . $e->getMessage());

            $this->dispatch('show-notification', [
                'title' => 'Error',
                'message' => 'Failed to create supplier. Please try again.',
                'type' => 'error'
            ]);
        }
    }

    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
    }

    public function render()
    {
        return view('livewire.backend.supplier.create-component')
            ->layout('layouts.backend.app');
    }
}
