<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SmartCard extends Model
{
    public static function markUsed($couponID)
    {
        DB::table('smartcards')->where('id', '=', $couponID)->update(['used' => true]);
    }

    public function ifNotExist()
    {
        return !self::ifExist();
    }

    public static function ifExist($codeA, $codeB, $codeC, $codeD, $codeE, $id = '')
    {
        $verifiedKeys = 0;
        $id = self::where([
            ['secretID_A', '=', $codeA],
            ['secretID_B', '=', $codeB],
            ['secretID_C', '=', $codeC],
            ['secretID_D', '=', $codeD],
            ['secretID_E', '=', $codeE]
        ]);
        if ($id->count() == 1) {
            self::touched($id->id);
            return $id->id;
        } else return false;
    }

    public static function touched($couponID)
    {
        DB::table('smartcards')->where('id', '=', $couponID)->update(['touched' => true]);
    }
}
