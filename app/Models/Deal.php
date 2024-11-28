<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Psy\VersionUpdater\Installer;

class Deal extends Model
{
    protected $primaryKey = 'deal_id';
    protected $fillable = [
        'date',
        'type',
        'total_cost',
        'car_id',
        'user_id',
    ];
    /**
     * Get the user that owns the Deal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class, 'deal_id');
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'deal_id');
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
