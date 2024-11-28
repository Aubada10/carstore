<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model
{
    protected $primaryKey = 'installment_id';
    protected $fillable = [
        'date',
        'amount',
        'deal_id',
    ];


    /**
     * Get the user that owns the Installment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }
}
