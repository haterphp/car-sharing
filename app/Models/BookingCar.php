<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'car_id'
    ];
    public $timestamps = false;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
