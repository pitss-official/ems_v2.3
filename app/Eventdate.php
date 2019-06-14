<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Eventdate extends Model
{
    //
    protected $hidden=['description','updated_at','created_at'];
    //this function will return the events occuring today as well as the event name and date id
    public static function getDateWiseEvents($date)
    {
        return DB::table('eventdates')
            ->where([['date','=',$date],
//                ['attendanceState','=',false]
            ])
            ->join('events','eventdates.eventID','=','events.id')
            ->select('eventdates.id','events.name','eventdates.motive','eventdates.eventID')
            ->orderBy('events.name','ASC')
            ->get();
    }
}
