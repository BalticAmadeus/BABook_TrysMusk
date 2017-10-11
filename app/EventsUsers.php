<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class EventsUsers extends Model
{
    protected $table = 'eventsUsers';

    protected $fillable = [
        'userId', 'eventId', 'status'
    ];
}