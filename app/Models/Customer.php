<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'email',
        'address',
        'date_of_birth',
        'gender',
        'loyalty_points',
        'total_spent',
        'blood_group',
        'allergies',
        'medical_history',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'loyalty_points' => 'decimal:2',
        'total_spent' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function loyaltyTransactions()
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_phone', 'phone');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_phone', 'phone');
    }

    public function discountApplicables()
    {
        return $this->morphMany(DiscountApplicable::class, 'applicable');
    }
}
