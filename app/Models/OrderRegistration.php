<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRegistration extends Model
{
    protected $table = "order_registration";
    protected $fillable = ['is_fulfilled', 'price', 'fulfilled_at', 'order_id', 'registration_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function exhibition()
    {
        return Exhibition::join("registrations", "exhibitions.id", "=", "registrations.exhibition_id")
            ->join("order_registration", "order_registration.registration_id", "=", "registrations.id")
            ->where("order_registration.id", "=", $this->id)
            ->select("exhibitions.*")
            ->first();
    }
}
