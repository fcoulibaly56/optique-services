<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model {
    protected $fillable = [
        'customer_id','type','scheduled_for','status','sent_at','responded_at','message_template',
    ];
    protected $casts = [
        'scheduled_for' => 'date',
        'sent_at'       => 'datetime',
        'responded_at'  => 'datetime',
    ];
    public function customer() { return $this->belongsTo(Customer::class); }
}
