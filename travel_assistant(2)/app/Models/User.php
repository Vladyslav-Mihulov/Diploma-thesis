<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;

class User extends Authenticatable
{
    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'f_name',
        'l_name',
        'created_at',
        'modify_at',
        'created_by',
        'modify_by',
    ];

    protected $hidden = [
        'password',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'users_id', 'roles_id');
    }

    public function searches()
    {
        return $this->hasMany(Search::class, 'users_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Result::class, 'favorite', 'users_id', 'result_id');
    }
}