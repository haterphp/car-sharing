<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'patronymic', 'phone', 'birth_date', 'passport_series', 'passport_number', 'password'
    ];
    public $timestamps = false;
    public $hidden = ['password', 'api_token', 'id'];

    public function generate_token()
    {
        $this->api_token = Hash::make(Str::random(15));
        $this->save();
        return $this->api_token;
    }

    public static function isset_user($phone)
    {
        return User::where(['phone' => $phone])->count();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function logout()
    {
        $this->api_token = null;
        $this->save();
    }
}
