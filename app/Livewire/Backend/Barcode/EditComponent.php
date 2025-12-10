<?php

namespace App\Livewire\Backend\Barcode;

use Livewire\Component;
use App\Models\Barcode;
use App\Models\Medicine;
use Illuminate\Support\Facades\Session;

class EditComponent extends Component
{
    public $barcodeId;
    public $medicine_id;
    public $barcode;
    public $barcode_type;
    public $is_active = true;

    protected $barcodeTypes = [
        'CODE128' => 'CODE128',
        'CODE39' => 'CODE39',
        'EAN13' => 'EAN-13',
        'EAN8' => 'EAN-8',
        'UPCA' => 'UPC-A',
        'UPCE' => 'UPC-E',
    ];

    protected function rules()
    {
        return [
            'medicine_id' => 'required|exists:medicines,id',
            'barcode' => 'required|string|max:50|unique:barcodes,barcode,' . $this->barcodeId,
            'barcode_type' => 'required|in:CODE128,CODE39,EAN13,EAN8,UPCA,UPCE',
            'is_active' => 'boolean',
        ];
    }

    protected $messages = [
        'medicine_id.required' => 'Please select a medicine',
        'barcode.required' => 'Barcode number is required',
        'barcode.unique' => 'This barcode already exists',
        'barcode_type.required' => 'Please select barcode type',
    ];

    public function mount($barcode)
    {
        $barcodeRecord = Barcode::findOrFail($barcode);
        $this->barcodeId = $barcodeRecord->id;
        $this->medicine_id = $barcodeRecord->medicine_id;
        $this->barcode = $barcodeRecord->barcode;
        $this->barcode_type = $barcodeRecord->barcode_type;
        $this->is_active = $barcodeRecord->is_active;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $barcode = Barcode::findOrFail($this->barcodeId);
        $barcode->update([
            'medicine_id' => $this->medicine_id,
            'barcode' => $this->barcode,
            'barcode_type' => $this->barcode_type,
            'is_active' => $this->is_active,
        ]);

        Session::flash('message', 'Barcode updated successfully!');

        // Check if the route expects a parameter and pass it correctly
        return redirect()->route('admin.medicine.barcode.view', $this->barcodeId);
    }

    // Computed properties for barcode types
    public function getBarcodeTypesProperty()
    {
        return $this->barcodeTypes;
    }

    // Computed property for medicines
    public function getMedicinesProperty()
    {
        return Medicine::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.backend.barcode.edit-component')
                ->layout('layouts.backend.app');
    }
}
