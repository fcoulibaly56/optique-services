<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {
    protected $fillable = ['conversation_id','sender_user_id','sender_role','body','sent_at'];
    protected $casts = ['sent_at' => 'datetime'];
    public function conversation() { return $this->belongsTo(Conversation::class); }
    public function sender()       { return $this->belongsTo(User::class, 'sender_user_id'); }
    public function reads() { return $this->hasMany(MessageRead::class); }
}
