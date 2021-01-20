<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestExcelence extends Model
{
    protected $table = "contest_excelence";
    public $fillable = ['id', 'year', 'contest_id', 'excelence_level_id'];
}
