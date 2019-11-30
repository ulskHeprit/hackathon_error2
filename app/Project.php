<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'creator_id', 'token',
    ];

    protected $hidden = [
        'token', 'token',
    ];

}
