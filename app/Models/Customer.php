<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

 class Customer extends Model {
    use SoftDeletes;

    protected $fillable = [
    'user_id', 'first_name', 'last_name', 'phone', 'email',
    'contact_preference', 'consent_at', 'internal_notes',
    'profession', 'address', 'birth_date'
];
    protected $casts = ['consent_at' => 'datetime'];

    public function user()          { return $this->belongsTo(User::class); }
    public function orders()        { return $this->hasMany(Order::class); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
    public function appointments()  { return $this->hasMany(Appointment::class); }
    public function conversations() { return $this->hasMany(Conversation::class); }
    public function followUps()     { return $this->hasMany(FollowUp::class); }
    public function getFullNameAttribute(): string {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
