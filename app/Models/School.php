<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['address', 'city', 'psc', 'ico', 'izo', 'name', 'email', 'web', 'phone', 'description', 'is_trustworthy', 'entity_type_id', 'district_id'];

    private ?EntityType $et = null; // cache

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

    public function entity_type()
    {
        return $this->belongsTo(EntityType::class);
    }

    public function type()
    {
        if($this->et == null){
            $this->et = $this->entity_type;
        }

        return $this->et->type;
    }

    // translation
    public function type_name($pad = 1)
    {
        $intl = [ // move somewhere else
            'school' => [
                1 => "škola",
                2 => "školy"
            ],
            'company' => [
                1 => "společnost",
                2 => "společnosti"
            ],
            'empl_dep' => [
                1 => "Úřad práce",
                2 => "Úřadu práce"
            ]
        ];

        if($this->et == null){
            $this->et = $this->entity_type;
        }

        if(!array_key_exists($this->et->type, $intl)){
            throw new Exception("Translation for type name {$this->et->type} not implemented");
        }
        if(!array_key_exists($pad, $intl[$this->et->type])){
            throw new Exception("Pad $pad for type name {$this->et->type} not implemented");
        }

        return $intl[$this->et->type][$pad];
    }

    private function get_type_data()
    {
        if($this->et == null){
            $this->et = $this->entity_type;
        }

        if(is_string($this->et->data)){
            $this->et->data = json_decode($this->et->data);
        }

        return $this->et->data;
    }

    public function type_can_have_related()
    {
        return $this->get_type_data()->can_have_related ?? false;
    }

    public function type_can_be_related_to()
    {
        return $this->get_type_data()->can_be_related_to ?? false;
    }

    public function type_has_free_exhibitions()
    {
        if($this->et == null){
            $this->et = $this->entity_type;
        }

        return $this->get_type_data()->has_free_exhibitions ?? false;
    }

    public function type_can_have_specializations()
    {
        if($this->et == null){
            $this->et = $this->entity_type;
        }

        return $this->get_type_data()->can_have_specializations ?? false;
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

    public function pipe_text()
    {
        $pipe_text = $this->type_name(1);
        $pipe_text .= ' | ';
        $pipe_text .= $this->city . ' <i>(okres ' . $this->district->name . ')</i>';

        return $pipe_text;
    }

    public function eligible_schools()
    {
        return $this->whereNotIn('schools.id', function($q){
            $q->select('company_school.school_id')
                ->from("company_school")
                ->where("company_school.company_id", "=", $this->id);
        })->join("entity_types", "entity_type_id", "=", "entity_types.id")
            ->where("entity_types.data->can_be_related_to", true);
    }

    public function contacts()
    {
        return $this->hasMany(SchoolContact::class);
    }

    public static function schools()
    {
        return School::join("entity_types", "entity_type_id", "=", "entity_types.id")->where("entity_types.type", "=", "school");
    }

    public static function companies()
    {
        return School::join("entity_types", "entity_type_id", "=", "entity_types.id")->where("entity_types.type", "=", "company");
    }
}
