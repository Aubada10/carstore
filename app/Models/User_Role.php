<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User_Role extends Model
{
    protected $fillable = [
        'employee_id',
        'user_id',
        'manager_id',
        'role_id'
    ];
    protected $table = "user_roles";

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }
}
