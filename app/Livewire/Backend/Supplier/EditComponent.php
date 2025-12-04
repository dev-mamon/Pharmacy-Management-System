<?php

namespace App\Livewire\Backend\Supplier;

use Exception;
use Livewire\Component;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditComponent extends Component
{
    public Supplier $supplier;

    public $name;
    public $contact_person;
    public $email;
    public $phone;
    public $address;
    public $is_active = true;

    // Define rules as a method instead of property
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email,' . $this->supplier->id,
            'phone' => 'required|string|max:20|unique:suppliers,phone,' . $this->supplier->id,
            'address' => 'nullable|string',
            'is_active' => 'boolean'
        ];
    }

    protected $messages = [
        'name.required' => 'Supplier name is required.',
        'phone.required' => 'Phone number is required.',
        'phone.unique' => 'This phone number is already registered.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.'
    ];

    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->name = $supplier->name;
        $this->contact_person = $supplier->contact_person;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;
        $this->address = $supplier->address;
        $this->is_active = $supplier->is_active;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $this->supplier->update([
                    'name' => $this->name,
                    'contact_person' => $this->contact_person,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'is_active' => $this->is_active
                ]);

                // Dispatch event for notifications
                $this->dispatch('supplier-updated', [
                    'title' => 'Supplier Updated',
                    'message' => "Supplier '{$this->name}' has been updated successfully.",
                    'type' => 'success'
                ]);

                // Redirect to suppliers list
                $this->redirect(route('admin.suppliers.index'), navigate: true);
            });
        } catch (Exception $e) {
            Log::error('Failed to update supplier: ' . $e->getMessage());

            $this->dispatch('show-notification', [
                'title' => 'Error',
                'message' => 'Failed to update supplier. Please try again.',
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
        return view('livewire.backend.supplier.edit-component')
            ->layout('layouts.backend.app');
    }
}
