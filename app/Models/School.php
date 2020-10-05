<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['address', 'city', 'psc', 'ico', 'izo', 'name', 'email', 'web', 'phone', 'description', 'is_trustworthy', 'is_school', 'district_id'];

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


    public function enabled_registrations()
    {
        return $this->ordered_registrations()
            ->join("schools", "registrations.school_id", "=", "schools.id")
            ->join("order_registration", "order_registration.registration_id", "=", "registrations.id")
            ->where(function($q){
                $q->whereNotNull("order_registration.fulfilled_at")
                    ->orWhere("schools.is_trustworthy", true);
            });
    }

    public function ordered_specializations()
    {
        return $this->specializations()
            ->join("prescribed_specializations", "specializations.prescribed_specialization_id", "=", "prescribed_specializations.id")
            ->join("field_of_studies", "field_of_studies.id", "=", "prescribed_specializations.field_of_study_id")
            ->join("type_of_studies", "type_of_studies.id", "=", "field_of_studies.type_of_study_id")
            ->orderBy("type_of_studies.id")
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

    public function related_companies()
    {
        return $this->belongsToMany(School::class, 'company_school', 'school_id', 'company_id');
    }

    public function related_schools()
    {
        return $this->belongsToMany(School::class, 'company_school', 'company_id', 'school_id');
    }

    public function pipe_text() {
        $pipe_text = $this->is_school ? 'škola' : 'firma';
        $pipe_text .= ' | ';
        $pipe_text .= $this->city . ' <i>(okres '.$this->district->name.')</i>';

        return $pipe_text;
    }

    public function eligible_schools()
    {
        return $this->whereNotIn('id', function($q){
            $q->select('company_school.school_id')
                ->from("company_school")
                ->where("company_school.company_id", "=", $this->id);
        })
            ->where("is_school", true);
    }
}
