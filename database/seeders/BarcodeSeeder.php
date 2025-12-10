<?php

namespace Database\Seeders;

use App\Models\Barcode;
use App\Models\Medicine;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BarcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing records
        Barcode::truncate();

        // Get all medicines
        $medicines = Medicine::all();

        if ($medicines->isEmpty()) {
            // If no medicines exist, create some first or show a message
            $this->command->warn('No medicines found. Please run MedicineSeeder first.');
            return;
        }

        // Sample barcode types
        $barcodeTypes = ['CODE128', 'CODE39', 'EAN13', 'EAN8', 'UPC-A', 'QRCODE'];

        // Sample barcode prefixes (for realistic barcodes)
        $prefixes = [
            'MED' => [100000, 999999],  // Medicine range
            'DRG' => [200000, 299999],  // Drug range
            'PHM' => [300000, 399999],  // Pharmacy range
            'HOS' => [400000, 499999],  // Hospital range
        ];

        // Array to store unique barcodes
        $barcodes = [];

        foreach ($medicines as $medicine) {
            // Generate 1-3 barcodes per medicine
            $barcodeCount = rand(1, 3);

            for ($i = 0; $i < $barcodeCount; $i++) {
                // Select random barcode type
                $barcodeType = $barcodeTypes[array_rand($barcodeTypes)];

                // Generate unique barcode
                $barcode = $this->generateUniqueBarcode($prefixes, $barcodes, $barcodeType);

                // Add to barcodes array to ensure uniqueness
                $barcodes[] = $barcode;

                // Create barcode record
                Barcode::create([
                    'medicine_id' => $medicine->id,
                    'barcode' => $barcode,
                    'barcode_type' => $barcodeType,
                    'is_active' => rand(0, 10) > 1, // 90% active, 10% inactive
                    'created_at' => now()->subDays(rand(0, 365)),
                    'updated_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }

        $this->command->info('Barcodes seeded successfully!');
        $this->command->info('Total barcodes created: ' . count($barcodes));
    }

    /**
     * Generate a unique barcode based on type and prefixes
     */
    private function generateUniqueBarcode(array $prefixes, array $existingBarcodes, string $type): string
    {
        $maxAttempts = 100; // Prevent infinite loop

        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            // Select random prefix
            $prefix = array_rand($prefixes);
            [$min, $max] = $prefixes[$prefix];

            // Generate number
            $number = rand($min, $max);

            // Format barcode based on type
            $barcode = $this->formatBarcode($prefix, $number, $type);

            // Check if barcode is unique
            if (!in_array($barcode, $existingBarcodes)) {
                return $barcode;
            }
        }

        // If we couldn't find a unique barcode after max attempts
        return $prefix . $number . '_' . uniqid();
    }

    /**
     * Format barcode based on type
     */
    private function formatBarcode(string $prefix, int $number, string $type): string
    {
        switch ($type) {
            case 'EAN13':
                // Generate 13-digit EAN barcode
                $base = str_pad($number, 12, '0', STR_PAD_LEFT);
                $checksum = $this->calculateEANChecksum($base);
                return $base . $checksum;

            case 'EAN8':
                // Generate 8-digit EAN barcode
                $base = str_pad($number, 7, '0', STR_PAD_LEFT);
                $checksum = $this->calculateEANChecksum($base);
                return $base . $checksum;

            case 'UPC-A':
                // Generate 12-digit UPC-A barcode
                $base = str_pad($number, 11, '0', STR_PAD_LEFT);
                $checksum = $this->calculateUPCAChecksum($base);
                return $base . $checksum;

            case 'QRCODE':
                // For QR codes, we can use a longer identifier
                return 'QR_' . $prefix . '_' . $number . '_' . rand(1000, 9999);

            default:
                // For CODE128, CODE39, etc.
                return $prefix . str_pad($number, 6, '0', STR_PAD_LEFT);
        }
    }

    /**
     * Calculate EAN checksum digit
     */
    private function calculateEANChecksum(string $base): int
    {
        $sum = 0;
        $length = strlen($base);

        for ($i = 0; $i < $length; $i++) {
            $digit = (int)$base[$i];
            // Multiply odd positions by 3, even positions by 1 (positions are 1-based)
            $sum += ($i % 2 === 0) ? $digit * 3 : $digit;
        }

        $checksum = (10 - ($sum % 10)) % 10;
        return $checksum;
    }

    /**
     * Calculate UPC-A checksum digit
     */
    private function calculateUPCAChecksum(string $base): int
    {
        $sum = 0;

        for ($i = 0; $i < 11; $i++) {
            $digit = (int)$base[$i];
            // Multiply odd positions by 3, even positions by 1 (positions are 1-based)
            $sum += ($i % 2 === 0) ? $digit * 3 : $digit;
        }

        $checksum = (10 - ($sum % 10)) % 10;
        return $checksum;
    }
}
