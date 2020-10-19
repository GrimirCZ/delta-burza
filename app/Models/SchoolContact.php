<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolContact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'body',
        'school_id'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
