<?php

namespace App\Livewire\Backend\Category;

use Exception;
use Livewire\Component;
use App\Models\Category;

class CreateComponent extends Component
{
    public $name;
    public $description;
    public $is_active = true;

    /**
     * Validation rules
     */
    protected $rules = [
        'name' => 'required|string|max:255|unique:categories,name',
        'description' => 'nullable|string',
        'is_active' => 'boolean'
    ];

    /**
     * Validation messages
     */
    protected $messages = [
        'name.required' => 'Category name is required.',
        'name.unique' => 'This category name already exists.',
        'name.max' => 'Category name should not exceed 255 characters.'
    ];

    /**
     * Save new category
     */
    public function save()
    {
        $this->validate();

        try {
            Category::create([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('success', 'Category created successfully!');
             return $this->redirect('/admin/categories', navigate: true);


        } catch (Exception $e) {
            session()->flash('error', 'Failed to create category: ' . $e->getMessage());
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
        return view('livewire.backend.category.create-component')
            ->layout('layouts.backend.app');
    }
}
