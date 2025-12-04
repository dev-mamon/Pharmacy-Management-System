<?php

namespace App\Livewire\Backend\Medicine;

use Livewire\Component;
use App\Models\Medicine;
use App\Models\Category;

class EditComponent extends Component
{
    public $medicine;

    public $name;
    public $generic_name;
    public $brand_name;
    public $strength;
    public $category_id;
    public $description;
    public $side_effects;
    public $manufacturer;
    public $requires_prescription = false;
    public $is_active = true;

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
        'is_active' => 'boolean',
    ];

    public function mount($id)
    {
        $this->medicine = Medicine::findOrFail($id);

        // Set component properties from the medicine model
        $this->name = $this->medicine->name;
        $this->generic_name = $this->medicine->generic_name;
        $this->brand_name = $this->medicine->brand_name;
        $this->strength = $this->medicine->strength;
        $this->category_id = $this->medicine->category_id;
        $this->description = $this->medicine->description;
        $this->side_effects = $this->medicine->side_effects;
        $this->manufacturer = $this->medicine->manufacturer;
        $this->requires_prescription = (bool) $this->medicine->requires_prescription;
        $this->is_active = (bool) $this->medicine->is_active;
    }

    public function update()
    {
        $this->validate();

        try {
            $this->medicine->update([
                'name' => $this->name,
                'generic_name' => $this->generic_name,
                'brand_name' => $this->brand_name,
                'strength' => $this->strength,
                'category_id' => $this->category_id,
                'description' => $this->description,
                'side_effects' => $this->side_effects,
                'manufacturer' => $this->manufacturer,
                'requires_prescription' => $this->requires_prescription,
                'is_active' => $this->is_active,
            ]);

            session()->flash('success', 'Medicine updated successfully.');
            return $this->redirect('/admin/medicines', navigate: true);

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating medicine: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.backend.medicine.edit-component', [
            'categories' => $categories,
            'medicine' => $this->medicine,
        ])->layout('layouts.backend.app');
    }
}
