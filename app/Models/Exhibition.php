<?php

namespace App\Models;

use App\Organizer;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exhibition extends Model
{
    protected $fillable = ['name', 'city', 'date', 'test_date', 'organizer_id', 'force_enable_join', 'district_id'];

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

    /**
     * @return bool
     * @deprecated
     */
    public function show_join_buttons()
    {
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

        return
            ($diffInDays < 2 && $date >= $now)
            // make join available two days before the exhibition from 8:00 to 8:45 am
            || $now->isoFormat("YYYY-MM-DD") == $this->test_date && $currentHour == 8 && $currentMinute >= 0 && $currentMinute <= 45
            || $this->force_enable_join;
    }

    private function createTimeStr($hours, $minutes)
    {
        return fill_number_to_length($hours, 2) . ":" . fill_number_to_length($minutes, 2);
    }

    private function should_enable($date, $start, $end)
    {
        if($date == null || $start == null || $end == null)
            return false;

        $currentTime = Carbon::now()->isoFormat("HH:mm");
        $startTime = $this->createTimeStr($start["hours"], $start['minutes']);
        $endTime = $this->createTimeStr($end["hours"], $end['minutes']);

        return Carbon::now()->isoFormat("YYYY-MM-DD") == $date
            && $currentTime >= $startTime
            && $currentTime <= $endTime;
    }

    public function enable_test_join_buttons()
    {
        $start = parse_time_string($this->test_event_start);
        $end = parse_time_string($this->test_event_end);

        return ($this->should_enable($this->test_date, $start, $end) && $this->has_test_event)
            || $this->force_enable_join;
    }

    public function enable_morning_join_buttons()
    {
        $start = parse_time_string($this->morning_event_start);
        $end = parse_time_string($this->morning_event_end);

        return ($this->should_enable($this->date, $start, $end) && $this->has_morning_event)
            || $this->force_enable_join;
    }

    public function enable_evening_join_buttons()
    {
        $start = parse_time_string($this->evening_event_start);
        $end = parse_time_string($this->evening_event_end);

        return ($this->should_enable($this->date, $start, $end) && $this->has_evening_event)
            || $this->force_enable_join;
    }

    public function enable_chat() : bool
    {
        return $this->enable_morning_join_buttons() || $this->enable_evening_join_buttons();
    }
}
