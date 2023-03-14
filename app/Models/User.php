<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Summary of User
 *
 * @method static checkRole()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'username', 'password', 'aadhar_no', 'mob_no'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserRoleAttribute()
    {
        return UserRole::with('role')
            ->where('user_id', $this->id)
            ->get();
    }

    /**
     * Summary of checkRole
     * @param mixed $role
     * @return bool
     */
    public function checkRole($role)
    {
        return UserRole::whereHas('role', function ($query) use ($role) {
            $query->where('name', '=', $role);
        })
            ->where('user_id', $this->id)
            ->first()
            ? true
            : false;
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
}
