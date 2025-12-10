<?php

namespace App\Livewire\Backend\Barcode;

use Livewire\Component;
use App\Models\Barcode;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ViewComponent extends Component
{
    public $barcode;
    public $barcodeImage;

    // Map your barcode types to Picqer's supported types
    private $barcodeTypeMap = [
        'CODE128' => 'C128',      // Changed from 'CODE128'
        'CODE39' => 'C39',        // Changed from 'CODE39'
        'EAN13' => 'EAN13',       // Already correct
        'EAN8' => 'EAN8',         // Already correct
        'UPCA' => 'UPCA',         // Already correct
        'UPCE' => 'UPCE',         // Already correct
    ];

    public function mount($barcode)
    {
        $this->barcode = Barcode::with('medicine')->findOrFail($barcode);
        $this->generateBarcodeImage();
    }

    private function generateBarcodeImage()
    {
        $generator = new BarcodeGeneratorPNG();

        // Get the mapped barcode type
        $barcodeType = $this->getMappedBarcodeType();

        try {
            $this->barcodeImage = base64_encode($generator->getBarcode(
                $this->barcode->barcode,
                $barcodeType,
                2, // Width factor
                50, // Height
                [255, 255, 255] // Background color
            ));
        } catch (\Exception $e) {
            // Fallback to CODE128 if the barcode type is not supported
            $this->barcodeImage = base64_encode($generator->getBarcode(
                $this->barcode->barcode,
                'C128',
                2,
                50,
                [255, 255, 255]
            ));
        }
    }

    private function getMappedBarcodeType()
    {
        $type = $this->barcode->barcode_type;

        // Return mapped type or default to C128 if not found
        return $this->barcodeTypeMap[$type] ?? 'C128';
    }

    public function printBarcode()
    {
        return redirect()->route('backend.barcodes.print', $this->barcode->id);
    }

    public function downloadBarcode()
    {
        $generator = new BarcodeGeneratorPNG();

        // Get the mapped barcode type
        $barcodeType = $this->getMappedBarcodeType();

        try {
            $imageData = $generator->getBarcode(
                $this->barcode->barcode,
                $barcodeType,
                2,
                50,
                [255, 255, 255]
            );
        } catch (\Exception $e) {
            // Fallback to CODE128
            $imageData = $generator->getBarcode(
                $this->barcode->barcode,
                'C128',
                2,
                50,
                [255, 255, 255]
            );
        }

        return response()->streamDownload(function () use ($imageData) {
            echo $imageData;
        }, 'barcode-' . $this->barcode->barcode . '.png', [
            'Content-Type' => 'image/png',
        ]);
    }

    public function render()
    {
        return view('livewire.backend.barcode.view-component')->layout('layouts.backend.app');
    }
}
