<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'email',
        'manager_name',
        'opening_time',
        'closing_time',
        'is_active',
    ];

    protected $casts = [
        'opening_time' => 'datetime',
        'closing_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function fromTransfers()
    {
        return $this->hasMany(StockTransfer::class, 'from_branch_id');
    }

    public function toTransfers()
    {
        return $this->hasMany(StockTransfer::class, 'to_branch_id');
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function salesReturns()
    {
        return $this->hasMany(SalesReturn::class);
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
}
