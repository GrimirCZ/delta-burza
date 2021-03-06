<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationVisit extends Model
{
    protected $fillable = ['ip_address', 'type', 'registration_id'];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
