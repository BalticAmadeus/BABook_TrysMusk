<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Comment
{
    protected $fillable = [
        'userId', 'eventId', 'comment'
    ];

}