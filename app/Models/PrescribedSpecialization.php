<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescribedSpecialization extends Model
{
    protected $fillable = ['name', 'code', 'field_of_study_id'];

    public function field_of_study()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }

    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }
}
