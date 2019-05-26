<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    public function event()
    {
        return $this->hasOne('App\Event');
    }
    public static function isNotExist($id)
    {
        if(Venue::where('id',$id)->count()!=1)
            return true;
        else return false;
    }
    public static function isExist($id)
    {
        return !self::isNotExist($id);
    }

}
