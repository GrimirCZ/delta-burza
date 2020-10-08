<?php

namespace App;

use App\Models\Exhibition;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    public function Exhibitions()
    {
        return $this->hasMany(Exhibition::class);
    }
}
