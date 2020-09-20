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

    public function ordered_registration()
    {
        return $this->hasMany(OrderRegistration::class);
    }

    public function registration()
    {
        return $this->hasManyThrough(Registration::class, OrderRegistration::class);
    }
}
