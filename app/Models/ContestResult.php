<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestResult extends Model
{
    public $fillable = ["id", "year", "region", "place", "name", "surname", "expoint", "contest_id", "school_id", "contest_level_id"];
}
