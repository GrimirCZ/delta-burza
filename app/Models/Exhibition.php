<?php

namespace App\Models;

use App\Organizer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exhibition extends Model
{
    protected $fillable = ['name', 'city', 'date', 'organizer_id', 'force_enable_join', 'district_id'];

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

        $diffInDays = $date->diffInDays($now);
        $currentHour = Carbon::now()->hour;
        $currentMinute = Carbon::now()->minute;

        return
            ($diffInDays < 2 && $date >= $now)
            // make join available two days before the exhibition from 8:00 to 8:45 am
            || $diffInDays <= 2 && $now < $date && $currentHour == 8 && $currentHour >= 0 && $currentMinute <= 45
            || $this->force_enable_join;
    }
}
