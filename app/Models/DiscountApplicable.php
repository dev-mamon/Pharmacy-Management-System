<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountApplicable extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_id',
        'applicable_type',
        'applicable_id',
    ];

    // Relationships
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function applicable()
    {
        return $this->morphTo();
    }
}
