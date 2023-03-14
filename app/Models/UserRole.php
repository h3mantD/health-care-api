<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class UserRole extends Model
{
    protected $collection = 'user_role';

    // protected $collection = 'user_role'

    protected $fillable = ['user_id', 'role_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
