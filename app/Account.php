<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function newStandardAccount($collegeUID,$creatorUID)
    {
        $holderName=User::where('collegeUID',$collegeUID)->firstOrFail()->fullName();
        $account= new Account();
        $account->name=$holderName." - Standard Account";
        $account->onHold=1;
        $account->type=0;
        $account->queueID=0;
        $account->balance=0;
        $account->number=$collegeUID;
        $account->collegeUID=$collegeUID;
        $account->createdBy=$creatorUID;
        $account->save();
        return $account->number;
    }
    public static function isSystemAccount($accountNumber)
    {
        $acType = (int)Self::findOrFail($accountNumber)->type;
        if ($acType != 0) return true;
        else return false;
    }
}
