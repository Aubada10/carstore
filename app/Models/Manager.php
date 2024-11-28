<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\Manager as Authenticatable;

class Manager extends Authenticatable
{
    use HasApiTokens;
    protected $primaryKey = 'manager_id';
    protected $table = 'managers';
    protected $fillable = ['name', 'email', 'password', 'role_id'];

    /**
     * Get all of the comments for the Manager
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }
    public function exchanges(): HasMany
    {
        return $this->hasMany(Exchange::class, 'manager_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
