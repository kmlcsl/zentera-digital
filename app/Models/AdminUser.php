<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'name',
        'password',
        'role',
        'is_active',
        'last_login_at',
        'last_login_ip'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Hash password when setting
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Check if admin is active
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Get admin role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Update last login info
     */
    public function updateLastLogin($ip = null)
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip ?? request()->ip()
        ]);
    }
}
