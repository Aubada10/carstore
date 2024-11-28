<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $primaryKey = 'supplier_id';
    protected $fillable = [
        'name',
        'wallet',
        'contact',
        'employee_id'


    ];

    /**
     * Get the user that owns the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    /**
     * Get all of the comments for the Supplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'supplier_id');
    }
}
