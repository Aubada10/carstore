<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $primaryKey = 'role_id';
    protected $fillable = ['name'];
    public const IS_ADMIN = 1;
    public const IS_EMPLOYEE = 2;
    public const IS_USER = 3;
    public const BLOCKED = 4;

    // public function comments(): HasMany
    // {
    //     return $this->hasMany(User_Role::class, 'role_id');
    // }
}
