<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $primaryKey = 'transaction_id';
    protected $fillable = [
        'value',
        'date',
        'description',
        'car_id',
        'deal_id',
        'box_id',
    ];


    public function box(): BelongsTo
    {
        return $this->belongsTo(Box::class, 'box_id');
    }
    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
