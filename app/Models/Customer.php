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
        'is_active'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'loyalty_points' => 'decimal:2',
        'total_spent' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Generate customer ID
     */
    public static function generateCustomerId()
    {
        $prefix = 'CUST-';
        $year = date('Y');
        $month = date('m');

        $lastCustomer = self::where('customer_id', 'like', $prefix . $year . $month . '%')
            ->orderBy('customer_id', 'desc')
            ->first();

        if ($lastCustomer) {
            $lastNumber = (int) substr($lastCustomer->customer_id, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $year . $month . $nextNumber;
    }

    /**
     * Scope for active customers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get age from date of birth
     */
    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) return null;
        return now()->diffInYears($this->date_of_birth);
    }

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
