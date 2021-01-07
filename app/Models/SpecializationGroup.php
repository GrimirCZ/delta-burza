<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecializationGroup extends Model
{
    protected $fillable = ['name', 'code'];

    function prescribed_specializations()
    {
        return $this->hasMany(PrescribedSpecialization::class);
    }
}
