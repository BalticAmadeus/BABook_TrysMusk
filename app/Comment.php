<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Comment extends Model
{
    protected $fillable = [
        'userId', 'eventId', 'comment'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'userId')->select(array('id', 'name'));
    }

}