<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'start_date', 'end_date', 'status', 'code'
    ];

    public function changeStatus()
    {
        $this->status = 2;
        $this->save();
    }

    public static function generate_code($unique = true)
    {
        $code = Str::upper(Str::random(5));

        if($unique)
            while(Booking::where(['code' => $code])->count())
                $code = Str::upper(Str::random(5));

        return $code;
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'booking_cars');
    }

    public function booking_cars()
    {
        return $this->hasMany(BookingCar::class);
    }

    public function status_name()
    {
        return $this->belongsTo(Status::class, 'status');
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
