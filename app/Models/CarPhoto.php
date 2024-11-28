<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarPhoto extends Model
{

    protected $primaryKey = 'car_photo_id';
    protected $fillable = ['path', 'car_id'];


    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
