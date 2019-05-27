<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $primaryKey = 'number';
    protected $visible = [''];

    public static function ifNotExist($number)
    {
        if (Account::where('number', $number)->count() != 1)
            return true;
        else return false;
    }

    public function user()
    {
        $this->belongsTo('App\User', 'collegeUID', 'collegeUID');
    }

    public function transactions()
    {
        $this->hasMany('App\Transaction');
    }
}
