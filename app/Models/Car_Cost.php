<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car_Cost extends Model
{
    protected $primaryKey = 'car_cost_id';
    protected $fillable = [
        'amount',
        'type',
        'company_id',
        'car_id',
    ];

    /**
     * Get the user that owns the Car_Cost
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
