<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamagedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'branch_id',
        'user_id',
        'quantity',
        'reason',
        'date_reported',
        'status',
        'estimated_loss',
    ];

    protected $casts = [
        'date_reported' => 'date',
        'estimated_loss' => 'decimal:2',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
