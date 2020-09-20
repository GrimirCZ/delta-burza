<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldOfStudy extends Model
{
    protected $fillable = ['name', 'type_of_study_id'];

    public function type_of_study()
    {
        return $this->belongsTo(TypeOfStudy::class);
    }

    public function specializations()
    {
        return $this->hasMany(Specialization::class);
    }
}
