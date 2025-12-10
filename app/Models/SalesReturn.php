<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_number',
        'sale_id',
        'branch_id',
        'user_id',
        'customer_id',
        'return_date',
        'total_amount',
        'reason',
        'status',
        'notes',
    ];

    protected $casts = [
        'return_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Generate return number
     */
    public static function generateReturnNumber(): string
    {
        $prefix = 'RTN-';
        $date = date('Ymd');
        $lastReturn = self::where('return_number', 'like', $prefix.$date.'%')
            ->orderBy('return_number', 'desc')
            ->first();

        if ($lastReturn) {
            $lastNumber = (int) substr($lastReturn->return_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix.$date.'-'.$newNumber;
    }

    /**
     * Relationships
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SalesReturnItem::class);
    }

    /**
     * Status badges
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'approved' => 'bg-blue-100 text-blue-800 border-blue-200',
            'rejected' => 'bg-red-100 text-red-800 border-red-200',
            'completed' => 'bg-green-100 text-green-800 border-green-200',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
    }
}
