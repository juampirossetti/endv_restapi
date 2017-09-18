<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GreenFriday extends Model
{
    public $table = 'green_fridays';

    public $timestamps = false;

    public $fillable = [
        'event_name',
    ];

    public function eventInfo(){
        return $this->morphOne('App\Models\Event', 'eventable');
    }
}