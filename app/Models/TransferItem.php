<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_transfer_id',
        'medicine_id',
        'quantity',
    ];

    // Relationships
    public function stockTransfer()
    {
        return $this->belongsTo(StockTransfer::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
