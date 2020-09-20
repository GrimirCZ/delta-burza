<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeOfStudy extends Model
{
    protected $fillable = ['name', 'code'];

    public function fields_of_study()
    {
        return $this->hasMany(FieldOfStudy::class);
    }
}
