<?php

namespace App\Livewire\Backend\Customer;

use App\Models\Customer;
use Livewire\Component;

class EditComponent extends Component
{
    public $customer;

    // Form properties
    public $customer_id;
    public $name;
    public $phone;
    public $email;
    public $address;
    public $date_of_birth;
    public $gender;
    public $blood_group;
    public $allergies;
    public $medical_history;
    public $is_active;

    /**
     * Mount method
     */
    public function mount($id = null)
    {
        $this->customer = Customer::findOrFail($id);

        // Populate form with customer data
        $this->customer_id = $this->customer->customer_id;
        $this->name = $this->customer->name;
        $this->phone = $this->customer->phone;
        $this->email = $this->customer->email;
        $this->address = $this->customer->address;
        $this->date_of_birth = $this->customer->date_of_birth ? $this->customer->date_of_birth->format('Y-m-d') : '';
        $this->gender = $this->customer->gender;
        $this->blood_group = $this->customer->blood_group;
        $this->allergies = $this->customer->allergies;
        $this->medical_history = $this->customer->medical_history;
        $this->is_active = (bool)$this->customer->is_active;
    }

    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'customer_id' => 'required|unique:customers,customer_id,' . $this->customer->id,
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,' . $this->customer->id,
            'email' => 'nullable|email|max:255|unique:customers,email,' . $this->customer->id,
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string|max:10',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Validation messages
     */
    protected $messages = [
        'customer_id.required' => 'Customer ID is required.',
        'customer_id.unique' => 'This Customer ID already exists.',
        'name.required' => 'Customer name is required.',
        'phone.required' => 'Phone number is required.',
        'phone.unique' => 'This phone number is already registered.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'date_of_birth.date' => 'Please enter a valid date.',
        'gender.in' => 'Please select a valid gender.'
    ];

    /**
     * Update customer
     */
    public function update()
    {
        $this->validate();

        try {
            $this->customer->update([
                'customer_id' => $this->customer_id,
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'date_of_birth' => $this->date_of_birth,
                'gender' => $this->gender,
                'blood_group' => $this->blood_group,
                'allergies' => $this->allergies,
                'medical_history' => $this->medical_history,
                'is_active' => $this->is_active,
            ]);

            session()->flash('success', 'Customer updated successfully!');
            return redirect()->route('admin.customers.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }

    /**
     * Toggle customer status
     */
    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
    }

    /**
     * Real-time validation
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.backend.customer.edit-component')
            ->layout('layouts.backend.app');
    }
}
