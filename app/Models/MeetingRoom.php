<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingRoom extends Model
{
    public $table = 'meeting_rooms';

    public $timestamps = false;

    public $fillable = [
        'event_type',
    ];

    public function eventInfo(){
        return $this->morphOne('App\Models\Event', 'eventable');
    }
}