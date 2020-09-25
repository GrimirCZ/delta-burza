<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['type', 'name', 'school_id', 'user_id'];

    public function school()
    {
       return $this->belongsTo(School::class);
    }
}
