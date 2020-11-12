<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityType extends Model
{
    protected $table = "entity_types";

    protected $fillable = [
        'type', 'data', 'data->importance', 'data->can_have_related', 'data->can_be_related_to', 'data->has_free_exhibitions', 'data->can_have_specializations'
    ];

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public static function get($type)
    {
        return EntityType::where("type", "=", $type)->first();
    }
}
