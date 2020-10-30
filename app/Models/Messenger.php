<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messenger extends Model
{
    protected $fillable = ['type', 'data', 'data->ip', 'data->school_id', 'data->session_id', 'data->registration_id', 'data->has_sent_message'];

    protected $casts = [
        'data' => 'array'
    ];

    public function received_messages()
    {
        return $this->hasMany(Message::class, "receiver_id");
    }

    public function sent_messages()
    {
        return $this->hasMany(Message::class, "sender_id");
    }
}
