<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $table = 'events';

    public $timestamps = false;

    public $fillable = [
        'date',
        'from',
        'until',
        'description'
    ];

    public $hidden = [
        'eventable_id'
    ];

    public function eventable(){
        return $this->morphTo();
    }
}
