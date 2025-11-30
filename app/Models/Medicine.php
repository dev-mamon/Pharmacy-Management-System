<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'generic_name',
        'brand_name',
        'strength',
        'category_id',
        'description',
        'side_effects',
        'manufacturer',
        'requires_prescription',
        'is_active',
    ];

    protected $casts = [
        'requires_prescription' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function alternatives()
    {
        return $this->hasMany(MedicineAlternative::class, 'medicine_id');
    }

    public function alternativeMedicines()
    {
        return $this->hasMany(MedicineAlternative::class, 'alternative_medicine_id');
    }

    public function barcodes()
    {
        return $this->hasMany(Barcode::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'medicine_category')
                    ->withTimestamps();
    }

    public function medicineCategories()
    {
        return $this->hasMany(MedicineCategory::class);
    }

    public function transferItems()
    {
        return $this->hasMany(TransferItem::class);
    }

    public function discountApplicables()
    {
        return $this->morphMany(DiscountApplicable::class, 'applicable');
    }
}
