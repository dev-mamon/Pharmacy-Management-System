<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function medicineCategories()
    {
        return $this->hasMany(MedicineCategory::class);
    }

    public function discountApplicables()
    {
        return $this->morphMany(DiscountApplicable::class, 'applicable');
    }
}
