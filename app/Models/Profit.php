<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profit extends Model
{
    protected $primaryKey = 'profit_id';
    protected $fillable = ['percentage'];

    /**
     * Get the user that owns the Profit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function car(): BelongsTo
    // {
    //     return $this->belongsTo(Car::class, 'profit_id');
    // }
}