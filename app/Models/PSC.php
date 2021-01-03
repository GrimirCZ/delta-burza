<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PSC extends Model
{
    protected $table = "psc";
    public $timestamps = false;

    protected $fillable = ["psc", "city", "district_id"];
}
