<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'mark',
        'car_number',
        'price',
        'branch_id'
    ];
    public $timestamps = false;

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeOfMark($query, $mark)
    {
        return $query->where('mark', 'like', "%{$mark}%");
    }

    public function scopeOfModel($query, $model)
    {
        return $query->where('title', 'like', "%{$model}%");
    }
}
