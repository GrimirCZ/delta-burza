<?php

namespace App\Models;

use App\Organizer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exhibition extends Model
{
    protected $fillable = ['name', 'city', 'date', 'organizer_id', 'district_id'];

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

    public function show_join_buttons()
    {
        $date = new Carbon($this->date);
        $now = Carbon::now()
            ->setHours(0)
            ->setSecond(0)
            ->setMinutes(0)
            ->setMicroseconds(0);

        $diff = $date->diffInDays($now);

        return $diff < 2 && $date >= $now;
    }
}
