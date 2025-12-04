<?php

namespace App\Livewire\Backend\Customer;

use Exception;
use Livewire\Component;
use App\Models\Customer;

class CreateComponent extends Component
{
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
    public $is_active = true;

    /**
     * Validation rules
     */
    protected $rules = [
        'customer_id' => 'required|unique:customers,customer_id',
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20|unique:customers,phone',
        'email' => 'nullable|email|max:255|unique:customers,email',
        'address' => 'nullable|string',
        'date_of_birth' => 'nullable|date',
        'gender' => 'nullable|in:male,female,other',
        'blood_group' => 'nullable|string|max:10',
        'allergies' => 'nullable|string',
        'medical_history' => 'nullable|string',
        'is_active' => 'boolean'
    ];

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
     * Mount method - generate customer ID
     */
    public function mount()
    {
        $this->customer_id = Customer::generateCustomerId();
    }

    /**
     * Save new customer
     */
    public function save()
    {
        $this->validate();

        try {
            Customer::create([
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
            session()->flash('success', 'Customer created successfully!');
           return $this->redirect('/admin/customers', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Failed to create customer: ' . $e->getMessage());
        }
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
        return view('livewire.backend.customer.create-component')
            ->layout('layouts.backend.app');
    }
}
