<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const TEAM_ROLES = [
    'opticien' => 'Opticien',
    'admin'    => 'Administrateur',
];

    protected $fillable = ['name', 'email', 'phone', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'bool',
    ];

    public function customer() { return $this->hasOne(Customer::class); }
    public function isStaff(): bool { return in_array($this->role, ['opticien', 'admin']); }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function scopeTeam($query)
{
    return $query->whereIn('role', array_keys(self::TEAM_ROLES));
}
}
