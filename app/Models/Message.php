<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['body', 'sender_id', 'receiver_id'];

    public function sender()
    {
        return $this->belongsTo(Messenger::class, "sender_id");
    }

    public function receiver()
    {
        return $this->belongsTo(Messenger::class, "receiver_id");
    }
}
