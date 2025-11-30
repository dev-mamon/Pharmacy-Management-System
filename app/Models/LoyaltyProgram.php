<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'points_per_purchase',
        'points_per_amount',
        'minimum_redemption_points',
        'point_value',
        'is_active',
        'valid_from',
        'valid_to',
    ];

    protected $casts = [
        'points_per_purchase' => 'decimal:2',
        'points_per_amount' => 'decimal:2',
        'minimum_redemption_points' => 'decimal:2',
        'point_value' => 'decimal:2',
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_to' => 'date',
    ];

    // Relationships
    public function loyaltyTransactions()
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }
}
