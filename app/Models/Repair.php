<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'device_type',
        'device_brand',
        'device_model',
        'issue_description',
        'estimated_cost',
        'final_cost',
        'status',
        'technician_notes',
        'estimated_completion'
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
        'estimated_completion' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($repair) {
            $repair->repair_number = 'REP' . date('Ymd') . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'diagnosis' => 'info',
            'repairing' => 'primary',
            'repaired' => 'success',
            'ready' => 'success',
            'delivered' => 'dark',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

}
