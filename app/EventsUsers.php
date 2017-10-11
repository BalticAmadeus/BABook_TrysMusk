<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class EventsUsers extends Model
{
    protected $fillable = [
        'userId', 'eventId', 'status'
    ];
}