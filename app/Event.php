<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'userId', 'groupId', 'title', 'date', 'comment', 'location'
    ];

    public function group()
    {
        return $this->belongsTo('App\Group', 'groupId')->select(array('id', 'name'));
    }
}