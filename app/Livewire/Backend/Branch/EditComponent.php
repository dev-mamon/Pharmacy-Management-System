<?php

namespace App\Livewire\Backend\Branch;

use Exception;
use Carbon\Carbon;
use App\Models\Branch;
use Livewire\Component;

class EditComponent extends Component
{
    public $branchId;
    public $branch;

    // Form properties
    public $name;
    public $code;
    public $address;
    public $phone;
    public $email;
    public $manager_name;
    public $opening_time;
    public $closing_time;
    public $is_active;
    public $last_updated;

    /**
     * Mount method to initialize data
     */
  public function mount($id = null)
{
    $this->branchId = $id;

    if ($this->branchId) {
        $this->branch = Branch::findOrFail($this->branchId);

        $this->name = $this->branch->name;
        $this->code = $this->branch->code;
        $this->address = $this->branch->address;
        $this->phone = $this->branch->phone;
        $this->email = $this->branch->email;
        $this->manager_name = $this->branch->manager_name;

        // Format opening and closing times
        $this->opening_time = $this->branch->opening_time
            ? Carbon::parse($this->branch->opening_time)->format('H:i')
            : null;

        $this->closing_time = $this->branch->closing_time
            ? Carbon::parse($this->branch->closing_time)->format('H:i')
            : null;

        $this->is_active = (bool)$this->branch->is_active;
        $this->last_updated = $this->branch->updated_at;
    }
}


    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code,' . $this->branchId,
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'manager_name' => 'nullable|string|max:255',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Validation messages
     */
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
     * Update branch
     */
    public function update()
    {
        // Validate data
        $this->validate();

        // Check if opening time is before closing time
        if (strtotime($this->opening_time) >= strtotime($this->closing_time)) {
            $this->addError('closing_time', 'Closing time must be after opening time.');
            return;
        }

        try {
            // Update branch
            $this->branch->update([
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
            session()->flash('success', 'Branch updated successfully!');

            // Redirect to branches index
            return redirect()->route('admin.branches.index');

        } catch (Exception $e) {
            session()->flash('error', 'Failed to update branch: ' . $e->getMessage());
        }
    }

    /**
     * Toggle branch status
     */
    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;

        // Update immediately if branch exists
        if ($this->branch) {
            $this->branch->update(['is_active' => $this->is_active]);
            session()->flash('success', 'Branch status updated!');
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
        return view('livewire.backend.branch.edit-component')
            ->layout('layouts.backend.app');
    }
}
