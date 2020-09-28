<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['address', 'city', 'psc', 'ico', 'izo', 'name', 'email', 'web', 'phone', 'description', 'district_id'];

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

    public function brojure()
    {
        return $this->files()->where("type", "brojure")->first()->name ?? "#";
    }

    public function ordered_registrations()
    {
        return $this->registrations()
            ->join("exhibitions", "exhibitions.id", "=", "registrations.exhibition_id")
            ->orderBy("exhibitions.date")
            ->select("registrations.*");
    }

    public function ordered_specializations()
    {
        return $this->specializations()
            ->join("prescribed_specializations", "specializations.prescribed_specialization_id", "=", "prescribed_specializations.id")
            ->orderBy("prescribed_specializations.code")
            ->orderBy("prescribed_specializations.name")
            ->orderBy("specializations.name")
            ->select("specializations.*");
    }


    public function main_contact()
    {
        return $this->users()
            ->where("is_main_contact", true)
            ->first();
    }

    public function images()
    {
        return $this->files()->where("type", "image");
    }
}
