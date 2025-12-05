<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'branch_id',
        'batch_number',
        'expiry_date',
        'purchase_price',
        'selling_price',
        'quantity',
        'min_stock_level',
        'reorder_level',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    // Relationships
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function expiryAlerts()
    {
        return $this->hasMany(ExpiryAlert::class);
    }

    public function lowStockAlerts()
    {
        return $this->hasMany(LowStockAlert::class);
    }

    public function damagedItems()
    {
        return $this->hasMany(DamagedItem::class);
    }

    // Scopes
    public function scopeLowStock($query)
    {
        return $query->where('quantity', '<=', $this->reorder_level);
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiry_date', '<=', now()->addDays($days));
    }

    public function scopeActive($query)
    {
        return $query->where('quantity', '>', 0);
    }

      public function isLowStock()
    {
        return $this->quantity <= $this->reorder_level && $this->quantity > 0;
    }

    public function isOutOfStock()
    {
        return $this->quantity <= 0;
    }

    public function isExpiringSoon()
    {
        return $this->expiry_date <= now()->addDays(30);
    }

    public function isExpired()
    {
        return $this->expiry_date <= now();
    }
}
