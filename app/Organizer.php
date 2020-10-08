<?php

namespace App;

use App\Models\Exhibition;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $fillable = ['address', 'city', 'psc', 'ico', 'name', 'short_name', 'email', 'phone',];

    public function Exhibitions()
    {
        return $this->hasMany(Exhibition::class);
    }
}
