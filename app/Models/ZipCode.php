<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    public $timestamps = false;

    protected $fillable = ["zip_code", "city", "district_id"];
}
