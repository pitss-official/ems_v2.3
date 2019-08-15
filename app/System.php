<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class System extends Model
{
    protected $table = "system";

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

    public static function defaultAttendanceRemarks()
    {
        return "Attendance Marked";
    }

    public static function getPropertyValueByName($name)
    {
        return Self::where('name', $name)->value('value');
    }

    public static function sanitize(array $validatedData, array $skipKeys = [])
    {
        $result = [];
        foreach ($validatedData as $key => $value) {
            if (in_array($key, $skipKeys)) {
                $result += [$key => $value];
            } else {
                if (is_array($value)) {
                    $result += [$key => self::sanitize($value)];
                } else {
                    $str = htmlspecialchars(strip_tags($value));
                    if ($str != '') $result += [$key => $str];
                    else $result += [$key => null];
                }
            }
        }
        return $result;
    }

    public static function randAlphaNum(int $count)
    {
        $array = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz_@#$*()";
        $result = "";
        for ($i = 0; $i < $count; $i++) {
            $result .= $array[rand(0, strlen($array) - 1)];
        }
        return $result;
    }

    public static function mailer($to, $mailableObject, $additional=array())
    {
        if (self::getPropertyValueByName('actions_should_queue_mails') == 1) {
            if (isset($additional['cc'])) Mail::to($to)->cc($additional['cc'])->queue($mailableObject);
            else Mail::to($to)->queue($mailableObject);
        }
        else{
            if (isset($additional['cc'])) Mail::to($to)->cc($additional['cc'])->sendNow($mailableObject);
            else Mail::to($to)->sendNow($mailableObject);
        }
    }
}
