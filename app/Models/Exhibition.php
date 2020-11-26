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
        $bussinessDayThreshold = 2;

        $date = (new Carbon($this->date))
            ->setHours(0)
            ->setSecond(0)
            ->setMinutes(0)
            ->setMicroseconds(0);

        $now = Carbon::now()
            ->setHours(0)
            ->setSecond(0)
            ->setMinutes(0)
            ->setMicroseconds(0);

        $diffInDays = $date->diffInDays($now);
        $currentHour = Carbon::now()->hour;
        $currentMinute = Carbon::now()->minute;

        $workDayDiff = 0;

        $workDayNow = Carbon::now()
            ->setHours(0)
            ->setSecond(0)
            ->setMinutes(0)
            ->setMicroseconds(0);

        // get workday difference between now and target date
        while($workDayNow < $date && $workDayDiff < $bussinessDayThreshold + 1){
            if(
                $workDayNow->dayOfWeek > 0 && $workDayNow->dayOfWeek < 6
                && Holiday::where("date", $workDayNow)->count() == 0
            ){
                $workDayDiff++;
            }

            $workDayNow->addDay();
        }

        return
            ($diffInDays < 2 && $date >= $now)
            // make join available two days before the exhibition from 8:00 to 8:45 am
            || $workDayDiff <= 2 && $now < $date && $currentHour == 8 && $currentMinute >= 0 && $currentMinute <= 45
            || $this->force_enable_join;
    }
}
