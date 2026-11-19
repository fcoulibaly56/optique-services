<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = ['name', 'code', 'coverage_percentage', 'notes'];
        public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
