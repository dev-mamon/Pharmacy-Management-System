<?php

namespace App\Livewire\Backend\Barcode;

use Livewire\Component;
use App\Models\Medicine;
use App\Models\Barcode;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Str;

class CreateComponent extends Component
{
    public $medicine_id;
    public $barcode_type = 'CODE128';
    public $quantity = 1;
    public $custom_barcode;
    public $use_custom = false;

    // Each item: ['value' => '...', 'image' => 'base64string']
    public $generatedBarcodes = [];

    protected $barcodeTypes = [
        'CODE128' => 'CODE128',
        'CODE39'  => 'CODE39',
        'EAN13'   => 'EAN-13',
        'EAN8'    => 'EAN-8',
        'UPCA'    => 'UPC-A',
        'UPCE'    => 'UPC-E',
    ];

    protected $rules = [
        'medicine_id'    => 'required|exists:medicines,id',
        'barcode_type'   => 'required|in:CODE128,CODE39,EAN13,EAN8,UPCA,UPCE',
        'quantity'       => 'required|integer|min:1|max:100',
        'custom_barcode' => 'nullable|string|max:50|unique:barcodes,barcode',
        'use_custom'     => 'boolean',
    ];

    protected $messages = [
        'medicine_id.required' => 'Please select a medicine',
        'barcode_type.required' => 'Please select barcode type',
        'quantity.required' => 'Please enter quantity',
        'custom_barcode.unique' => 'This barcode already exists',
    ];

    public function mount()
    {
        $this->generateBarcodePreview();
    }

    /**
     * Map your human-friendly barcode_type to the Picqer constant.
     */
    private function getBarcodeTypeConstant()
    {
        // BarcodeGeneratorPNG constants are like: TYPE_CODE_128, TYPE_CODE_39, TYPE_EAN_13 ...
        switch ($this->barcode_type) {
            case 'CODE39':
                return BarcodeGeneratorPNG::TYPE_CODE_39;
            case 'EAN13':
                return BarcodeGeneratorPNG::TYPE_EAN_13;
            case 'EAN8':
                return BarcodeGeneratorPNG::TYPE_EAN_8;
            case 'UPCA':
                return BarcodeGeneratorPNG::TYPE_UPC_A;
            case 'UPCE':
                return BarcodeGeneratorPNG::TYPE_UPC_E;
            case 'CODE128':
            default:
                return BarcodeGeneratorPNG::TYPE_CODE_128;
        }
    }

    /**
     * Create preview values and base64 images (limit previews to 5).
     */
    public function generateBarcodePreview()
    {
        $generator = new BarcodeGeneratorPNG();

        $this->generatedBarcodes = [];

        if ($this->use_custom && $this->custom_barcode) {
            $value = $this->custom_barcode;
            $img  = base64_encode($generator->getBarcode($value, $this->getBarcodeTypeConstant()));
            $this->generatedBarcodes[] = ['value' => $value, 'image' => $img];
            return;
        }

        $previewCount = min($this->quantity, 5);

        for ($i = 0; $i < $previewCount; $i++) {
            $value = $this->generateUniqueBarcodeValue();
            $img   = base64_encode($generator->getBarcode($value, $this->getBarcodeTypeConstant()));
            $this->generatedBarcodes[] = ['value' => $value, 'image' => $img];
        }
    }

    private function generateUniqueBarcodeValue(): string
    {
        do {
            switch ($this->barcode_type) {
                case 'EAN13':
                    $barcode = '8' . str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
                    break;
                case 'EAN8':
                    $barcode = str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);
                    break;
                case 'UPCA':
                    $barcode = '1' . str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
                    break;
                case 'UPCE':
                    $barcode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    break;
                case 'CODE39':
                    $barcode = 'MED' . strtoupper(Str::random(7));
                    break;
                default: // CODE128
                    $barcode = 'PH' . date('Ymd') . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
                    break;
            }
        } while (Barcode::where('barcode', $barcode)->exists());

        return $barcode;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        // regenerate preview when these properties change
        if (in_array($propertyName, ['barcode_type', 'quantity', 'use_custom', 'custom_barcode'])) {
            $this->generateBarcodePreview();
        }
    }

    public function save()
    {
        $this->validate();

        $barcodes = [];

        for ($i = 0; $i < $this->quantity; $i++) {
            if ($this->use_custom && $this->custom_barcode && $i === 0) {
                $barcodeValue = $this->custom_barcode;
            } else {
                $barcodeValue = $this->generateUniqueBarcodeValue();
            }

            $barcode = Barcode::create([
                'medicine_id' => $this->medicine_id,
                'barcode' => $barcodeValue,
                'barcode_type' => $this->barcode_type,
                'is_active' => true,
            ]);

            $barcodes[] = $barcode;
        }

        if ($this->quantity == 1) {
            session()->flash('message', 'Barcode generated successfully!');
            return redirect()->route('admin.branches.view', $barcodes[0]->id);
        }

        session()->flash('message', $this->quantity . ' barcodes generated successfully!');
        return redirect()->route('admin.medicine.barcode');
    }

    // Expose properties to the view
    public function getBarcodeTypesProperty()
    {
        return $this->barcodeTypes;
    }

    public function getMedicinesProperty()
    {
        return Medicine::where('is_active', true)->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.backend.barcode.create-component', [
            'barcodeTypes' => $this->barcodeTypes,
            'medicines' => $this->medicines,
        ])->layout('layouts.backend.app');
    }
}
