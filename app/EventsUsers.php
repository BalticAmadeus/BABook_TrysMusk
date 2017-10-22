<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class EventsUsers extends Model
{
    protected $table = 'eventsUsers';

    protected $fillable = [
        'userId', 'eventId', 'status'
    ];

    public function users() {
        return $this->hasMany('App\User', 'id', 'userId')->select(array('id', 'name'));
    }

    /*public function userStatus() {
        return $this->hasMany('App\User', 'id', 'userId')->select(array('id'));
    }*/
}