<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'school_id',
        'exhibition_id',
        'morning_event',
        'evening_event',
        'is_disabled'];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function visits()
    {
        return $this->hasMany(RegistrationVisit::class);
    }

    public function order_registration()
    {
        return $this->hasOne(OrderRegistration::class);
    }
}
