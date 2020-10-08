<?php

namespace App\Models;

use App\Organizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exhibition extends Model
{
    protected $fillable = ['name', 'city', 'date', 'district_id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }
}
