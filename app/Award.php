<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    //
    public function event()
    {
        return $this->belongsTo('App\Event','eventID','id');
    }

    public function receiver()
    {
        return $this->hasOne('App\User','collegeUID','collegeUID');
    }
}
