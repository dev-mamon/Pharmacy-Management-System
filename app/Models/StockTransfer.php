<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_number',
        'from_branch_id',
        'to_branch_id',
        'user_id',
        'transfer_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'transfer_date' => 'date',
    ];

    // Relationships
    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transferItems()
    {
        return $this->hasMany(TransferItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->transfer_number = 'TRF-' . date('Ymd') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }
}
