<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model {
    protected $fillable = ['name','phone','email','message','consent_at','processed'];
    protected $casts = ['consent_at' => 'datetime', 'processed' => 'bool'];
}
