<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'id',
        'title',
        'content',
        'date',
        'cover_image',
        'show'
    ];
}
