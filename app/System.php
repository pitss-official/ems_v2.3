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
    public static function approveAttendanceLevel()
    {
        return 1000;
    }

    public function canUserViewSettings(int $collegeUID)
    {

    }
    public function canUserAlterSettings(int $collegeUID)
    {

    }
    public static function defaultAttendanceRemarks()
    {
        return "Attendance Marked";
    }
    public static function getPropertyValueByName($name)
    {
        return Self::where('name',$name)->pluck('value');
    }
}
