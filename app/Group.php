<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Group extends Model
{
    protected $fillable = [
        'name'
    ];

    public function events()
    {
        return $this->hasMany('App\Event', 'groupId', 'id');
    }
}