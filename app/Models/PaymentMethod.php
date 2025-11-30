<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_active',
        'processing_fee',
        'processor',
        'config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'processing_fee' => 'decimal:2',
        'config' => 'array',
    ];
}
