<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model {
    protected $fillable = [
        'customer_id','order_id','subject','status','assigned_to','last_message_at',
    ];
    protected $casts = ['last_message_at' => 'datetime'];
    public function customer()  { return $this->belongsTo(Customer::class); }
    public function order()     { return $this->belongsTo(Order::class); }
    public function messages()  { return $this->hasMany(Message::class)->orderBy('created_at'); }
    public function assignedTo(){ return $this->belongsTo(User::class, 'assigned_to'); }
}
