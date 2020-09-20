<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name'];

    public function neighboring_regions()
    {
        return $this->belongsToMany(Region::class, 'neighboring_regions', 'master_id', 'neighbor_id');
    }

    public function districts()
    {
        return $this->hasMany(Region::class);
    }
}
