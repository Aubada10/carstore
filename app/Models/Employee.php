<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\Employee as Authenticatable;

class Employee extends Authenticatable
{

    use HasApiTokens;
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'role_id',
        'manager_id',
    ];
    /**
     * Get the user that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'employee_id');
    }


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'employee_id');
    }
}
