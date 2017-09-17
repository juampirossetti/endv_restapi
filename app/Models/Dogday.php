<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dogday extends Model
{
    public $table = 'dogdays';

    public $timestamps = false;

    public $fillable = [
        'pet_name',
    ];

    public function eventInfo(){
        return $this->morphOne('App\Models\Event', 'eventable');
    }
}
