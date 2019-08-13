<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingPayment extends Model
{
    public function debitAccount()
    {
        return $this->hasOne('App\Account', 'number', 'debitAccountNumber');
    }
    public function creditAccount()
    {
        return $this->hasOne('App\Account', 'number', 'creditAccountNumber');
    }
    public function user()
    {
        return $this->hasOne('App\User','collegeUID','collegeUID');
    }
}
