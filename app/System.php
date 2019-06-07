<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $table="system";
    public static function queueAccount()
    {
        return 99887766;
    }
    public static function sendMoneyLevel()
    {
        return 1;
    }

    public function canUserViewSettings(int $collegeUID)
    {

    }
    public function canUserAlterSettings(int $collegeUID)
    {

    }
}
