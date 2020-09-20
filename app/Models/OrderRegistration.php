<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRegistration extends Model
{
    protected $fillable = ['is_fulfilled', 'price', 'fulfilled_at', 'order_id', 'registration_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
