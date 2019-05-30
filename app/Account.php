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
    public function newStandardAccount($collegeUID,$creatorUID=99887766)
    {
        $holder=User::where('collegeUID',$collegeUID);
        $holderName=$holder->fullName();
        $account= new Account();
        $account->name=$holderName." - Standard Account";
        $account->onHold=1;
        $account->type=0;
        $account->queueID=0;
        $account->balance=0;
        $account->number=$collegeUID;
        $account->collegeUID=$collegeUID;
        $account->save();
        return $account->number;
    }
}
