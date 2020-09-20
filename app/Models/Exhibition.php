<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    protected $fillable = ['name','city', 'date', 'district_id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
