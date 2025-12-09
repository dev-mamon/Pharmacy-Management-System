<?php

namespace App\Livewire\Backend\Medicine;

use App\Models\Category;
use App\Models\Medicine;
use Livewire\Component;

class CreateComponent extends Component
{
    public $name;

    public $generic_name;

    public $brand_name;

    public $strength;

    public $category_id;

    public $description;

    public $side_effects;

    public $manufacturer;

    public $requires_prescription = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'generic_name' => 'required|string|max:255',
        'brand_name' => 'required|string|max:255',
        'strength' => 'nullable|string|max:100',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        'side_effects' => 'nullable|string',
        'manufacturer' => 'nullable|string|max:255',
        'requires_prescription' => 'boolean',
    ];

    public function mount()
    {
        // Initialize with default values if needed
    }

    public function save()
    {
        $this->validate();

        try {
            Medicine::create([
                'name' => $this->name,
                'generic_name' => $this->generic_name,
                'brand_name' => $this->brand_name,
                'strength' => $this->strength,
                'category_id' => $this->category_id,
                'description' => $this->description,
                'side_effects' => $this->side_effects,
                'manufacturer' => $this->manufacturer,
                'requires_prescription' => $this->requires_prescription,
            ]);

            session()->flash('message', 'Medicine created successfully.');

            return $this->redirect('/admin/medicines', navigate: true);

        } catch (\Exception $e) {
            session()->flash('error', 'Error creating medicine: '.$e->getMessage());
        }
    }

    public function render()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.backend.medicine.create-component', [
            'categories' => $categories,
        ])->layout('layouts.backend.app');
    }
}
