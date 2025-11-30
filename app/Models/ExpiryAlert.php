<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiryAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'branch_id',
        'expiry_date',
        'days_until_expiry',
        'alert_level',
        'is_notified',
        'notified_at',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_notified' => 'boolean',
        'notified_at' => 'datetime',
    ];

    // Relationships
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
