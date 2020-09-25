<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['due_date', 'school_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function ordered_registrations()
    {
        return $this->hasMany(OrderRegistration::class);
    }

    public function registration()
    {
        return $this->hasManyThrough(Registration::class, OrderRegistration::class);
    }

    public function price()
    {
        return $this->join("order_registration", "orders.id", "=", "order_registration.order_id")
            ->where("orders.id", "=", $this->id)
            ->sum("order_registration.price");
    }

    public function fulfilled()
    {
        return OrderRegistration::where("order_id", "=", $this->id)->whereNull("fulfilled_at")->count() == 0;
    }

}
