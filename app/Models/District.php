<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['id', 'name', 'region_id'];

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function exhibitions()
    {
        return $this->hasMany(Exhibition::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
