<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = ['name', 'description', 'school_id', 'field_of_study_id'];

    public function prescribed_specialization()
    {
        return $this->belongsTo(PrescribedSpecialization::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
