<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrescribedSpecialization extends Model
{
    protected $fillable = ['name', 'code', 'field_of_study_id'];

    public function field_of_study() : BelongsTo
    {
        return $this->belongsTo(FieldOfStudy::class);
    }

    public function specializations() : HasMany
    {
        return $this->hasMany(Specialization::class);
    }

    public function specialization_group() : BelongsTo
    {
        return $this->belongsTo(SpecializationGroup::class);
    }
}
