<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    //
    protected $fillable=['parentID','eventID','value','name','parent','createdBy','account','remainingValue'];
    public static function ifNotExist($budgetID)
    {

    }

    public static function ifExist($budgetID)
    {

    }

    public function event()
    {
        return $this->hasOne('App\Event', 'id', 'eventID');
    }

    public function account()
    {
        return $this->hasOne('App\Event', 'number', 'accountNumber');
    }
}
