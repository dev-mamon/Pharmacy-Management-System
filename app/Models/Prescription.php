<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'patient_name',
        'patient_age',
        'patient_phone',
        'doctor_name',
        'doctor_notes',
        'prescription_date',
        'status',
    ];

    protected $casts = [
        'prescription_date' => 'date',
    ];

    // Relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'patient_phone', 'phone');
    }
}
