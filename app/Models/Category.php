<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

     use HasFactory;
     protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the route key for the model (use ID instead of slug)
     */
    public function getRouteKeyName()
    {
        return 'id'; // Changed from 'slug' to 'id'
    }

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
