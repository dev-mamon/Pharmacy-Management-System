<?php

namespace App\Livewire\Backend\Branch;

use App\Models\Branch;
use Livewire\Component;
use Illuminate\Support\Str;

class CreateComponent extends Component
{
    // Form properties
    public $name;
    public $code;
    public $address;
    public $phone;
    public $email;
    public $manager_name;
    public $opening_time = '09:00';
    public $closing_time = '18:00';
    public $is_active = true;

    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:branches,code',
        'address' => 'required|string',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'manager_name' => 'nullable|string|max:255',
        'opening_time' => 'required|date_format:H:i',
        'closing_time' => 'required|date_format:H:i',
        'is_active' => 'boolean'
    ];

    // Validation messages
    protected $messages = [
        'name.required' => 'Branch name is required.',
        'code.required' => 'Branch code is required.',
        'code.unique' => 'This branch code already exists.',
        'address.required' => 'Address is required.',
        'phone.required' => 'Phone number is required.',
        'email.email' => 'Please enter a valid email address.',
        'opening_time.required' => 'Opening time is required.',
        'closing_time.required' => 'Closing time is required.',
    ];

    /**
     * Generate branch code automatically
     */
    public function generateCode()
    {
        if (!$this->code && $this->name) {
            $prefix = strtoupper(Str::limit(Str::slug($this->name), 3, ''));
            $random = strtoupper(Str::random(3));
            $this->code = $prefix . '-' . $random;
        }
    }

    /**
     * Save new branch
     */
    public function save()
    {
        // Validate data
        $this->validate();

        // Check if opening time is before closing time
        if (strtotime($this->opening_time) >= strtotime($this->closing_time)) {
            $this->addError('closing_time', 'Closing time must be after opening time.');
            return;
        }

        try {
            // Create new branch
            Branch::create([
                'name' => $this->name,
                'code' => $this->code,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'manager_name' => $this->manager_name,
                'opening_time' => $this->opening_time,
                'closing_time' => $this->closing_time,
                'is_active' => $this->is_active,
            ]);

            // Flash success message
            session()->flash('success', 'Branch created successfully!');

            // Redirect to branches index
            return redirect()->route('admin.branches.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create branch: ' . $e->getMessage());
        }
    }

    /**
     * Real-time validation
     */
    public function updated($propertyName)
    {
        // Generate code when name changes
        if ($propertyName === 'name') {
            $this->generateCode();
        }

        // Validate single field
        $this->validateOnly($propertyName);
    }

    /**
     * Render component
     */
    public function render()
    {
        return view('livewire.backend.branch.create-component')
            ->layout('layouts.backend.app');
    }
}
