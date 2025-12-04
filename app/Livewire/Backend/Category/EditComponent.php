<?php

namespace App\Livewire\Backend\Category;

use App\Models\Category;
use Livewire\Component;

class EditComponent extends Component
{
    public $category;

    // Form properties
    public $name;
    public $description;
    public $is_active;


    /**
     * Mount method - use ID instead of route model binding
     */
   public function mount($category)
{
    // Get the category ID from the route parameter
    $categoryId = $category;

    // Load the category
    $this->category = Category::findOrFail($categoryId);

    // Populate form with category data
    $this->name = $this->category->name;
    $this->description = $this->category->description;
    $this->is_active = (bool)$this->category->is_active;
}

    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Validation messages
     */
    protected $messages = [
        'name.required' => 'Category name is required.',
        'name.unique' => 'This category name already exists.',
        'name.max' => 'Category name should not exceed 255 characters.'
    ];

    /**
     * Update category
     */
    public function update()
    {
        $this->validate();

        try {
            $this->category->update([
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);

            session()->flash('success', 'Category updated successfully!');
            return $this->redirect('/admin/categories', navigate: true);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Toggle category status
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
        return view('livewire.backend.category.edit-component')
            ->layout('layouts.backend.app');
    }
}
