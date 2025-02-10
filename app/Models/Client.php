<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'meter_code', 'email', 'phone_number', 'status'];

    public function billings()
    {
        return $this->hasMany(Billing::class); // A Client has many Billings
    }
}
