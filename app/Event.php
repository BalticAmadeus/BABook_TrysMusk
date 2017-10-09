<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'userId', 'groupId', 'title', 'date', 'comment', 'location'
    ];
}