<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $primaryKey = 'company_id';
    protected $fillable = [
        'name',
        'contact_details',
        'type',
    ];


    public function car_costs(): HasMany
    {
        return $this->hasMany(Car_Cost::class, 'company_id');
    }
}
