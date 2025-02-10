<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',        // Foreign key to clients table
        'meter_cubic_usage',
        'amount',
        'payment_status',
        'billing_cycle',
        'billing_date',
        'due_date',
    ];

    protected $dates = [
        'billing_date',
        'due_date',
    ];

    // Define the relationship with the Client model
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // Accessor to automatically calculate amount based on meter_cubic_usage
    public function getAmountAttribute()
    {
        $pricePerCubicMeter = 10; // Example price per cubic meter
        return $this->meter_cubic_usage * $pricePerCubicMeter;
    }

    // Example boot method for custom validation
    public static function boot()
    {
        parent::boot();

        static::creating(function ($billing) {
            // Ensure the meter_cubic_usage is positive
            if ($billing->meter_cubic_usage <= 0) {
                throw new \Exception('Meter cubic usage must be greater than zero.');
            }
        });
    }
}
