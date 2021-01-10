<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamResult extends Model
{
    protected $fillable = [
        'id', 'year', 'subject', 'type',
        'podil', 'prihlaseno', 'omluveno', 'vylouceno', 'konalo', 'neuspelo', 'uspelo',
        'odlozeny', 'opravny', 'nahradny',
        'percentil', 'odchylka', 'median', 'rozpeti', 'percentil25', 'percentil75',
        'school_id', 'specialization_group_id'
    ];

    public function school() : BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function specialization_group() : BelongsTo
    {
        return $this->belongsTo(SpecializationGroup::class);
    }
}
