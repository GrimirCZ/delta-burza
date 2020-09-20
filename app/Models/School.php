<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['address', 'ico', 'izo', 'name', 'email', 'web', 'phone', 'district_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function logo()
    {
        return $this->files()->where("type", "logo")->first()->name ?? "#";
    }
}
