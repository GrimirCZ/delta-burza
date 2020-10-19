<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'school_id',
        'exhibition_id',
        'morning_event',
        'evening_event'];

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

    public function is_enabled()
    {
        return $this->order_registration->fulfilled_at != null || $this->school->is_trustworthy;
    }

    private function provider_from_str($str)
    {
        if(preg_match("/teams\.microsoft/", $str)){
            return 'ms';
        } else if(preg_match('/meet\.google/', $str)){
            return 'google';
        }

        return 'other';
    }

    public function get_provider($e = null)
    {
        if($e == "evening"){
            return $this->provider_from_str($this->evening_event);
        } else if($e == "morning"){
            return $this->provider_from_str($this->morning_event);
        }

        return $this->provider_from_str($this->morning_event);
    }

    public function google_get_code($e)
    {
        if($e == "evening"){
            $src = $this->evening_event;
        } else if($e == "morning"){
            $src = $this->morning_event;
        }

        $match = [];

        if(preg_match("/\w{3}-\w{4}-\w{3}/", $src, $match)){
            return '(' . $match[0] . ')';
        }

        return '';
    }

    public function get_try_link()
    {
        return Carbon::now()->hour > 12 ? $this->evening_event : $this->morning_event;
    }
}
