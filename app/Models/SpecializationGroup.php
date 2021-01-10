<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecializationGroup extends Model
{
    protected $fillable = ['name', 'code'];

    function prescribed_specializations() : HasMany
    {
        return $this->hasMany(PrescribedSpecialization::class);
    }

    function exam_results() : HasMany
    {
        return $this->hasMany(ExamResult::class);
    }
}
