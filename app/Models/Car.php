<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PhpParser\Node\Expr\Empty_;

class Car extends Model
{
    protected $primaryKey = 'car_id';
    protected $fillable = [
        'model',
        'year',
        'color',
        'company',
        'plate_number',
        'price',
        'available',
        'employee_id',
        'supplier_id',
        'profit_id'
    ];

    /**
     * Get the user that owns the Car
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {

        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function supplier(): BelongsTo
    {

        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    // error warning
    public function profit(): BelongsTo
    {
        return $this->belongsTo(Profit::class, 'profit_id');
    }


    public function car_costs(): HasMany
    {

        return $this->hasMany(Car_Cost::class, 'car_id');
    }
    public function car_photos(): HasMany
    {

        return $this->hasMany(CarPhoto::class, 'car_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'car_id');
    }
}
