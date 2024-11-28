<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Box extends Model
{
    protected $primaryKey = 'box_id';
    protected $fillable = ['value'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'box_id');
    }
}
