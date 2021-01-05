<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionReport extends Model
{
    protected $fillable = ['start_date', 'end_date', 'url', 'school_ico'];


    public function school() : BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
