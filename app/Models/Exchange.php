<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{

    protected $primaryKey = 'exchange_id';

    protected $fillable = [
        'price',
        'date',
        'manager_id',
    ];
}
