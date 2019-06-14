<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class SmartCard extends Model
{
    protected $table="smartcards";
    protected $fillable=['sIDA','sIDB','sIDC','sIDD','sIDE','eventID'];
    private static function randFiveChars()
    {
        $array="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";
        $result="";
        for($i=0;$i<5;$i++)
        {
            $result.=$array[rand(0,strlen($array)-1)];
        }
        return $result;
    }
    private static function generateCard($eventID)
    {
        $codeA=Self::randFiveChars();
        $codeB=Self::randFiveChars();
        $codeC=Self::randFiveChars();
        $codeD=Self::randFiveChars();
        $codeE=Self::randFiveChars();
        if((self::where([
            ['sIDA', '=', $codeA],
            ['sIDB', '=', $codeB],
            ['sIDC', '=', $codeC],
            ['sIDD', '=', $codeD],
            ['sIDE', '=', $codeE]
        ])->count()==0)
//            &&$codeA!=$codeB
//            &&$codeA!=$codeC
//            &&$codeA!=$codeD
//            &&$codeA!=$codeE
//            &&$codeB!=$codeC
//            &&$codeB!=$codeD
//            &&$codeB!=$codeE
//            &&$codeC!=$codeD
//            &&$codeC!=$codeE
//            &&$codeD!=$codeE
//            &&(self::where('sIDA', '=', $codeA)->orWhere('sIDA', '=', $codeB)->orWhere('sIDA', '=', $codeC)->orWhere('sIDA', '=', $codeD)->orWhere('sIDA', '=', $codeE)->count()==0)
//            &&(self::where('sIDB', '=', $codeA)->orWhere('sIDB', '=', $codeB)->orWhere('sIDB', '=', $codeC)->orWhere('sIDB', '=', $codeD)->orWhere('sIDB', '=', $codeE)->count()==0)
//            &&(self::where('sIDC', '=', $codeA)->orWhere('sIDC', '=', $codeB)->orWhere('sIDC', '=', $codeC)->orWhere('sIDC', '=', $codeD)->orWhere('sIDC', '=', $codeE)->count()==0)
//            &&(self::where('sIDD', '=', $codeA)->orWhere('sIDD', '=', $codeB)->orWhere('sIDD', '=', $codeC)->orWhere('sIDD', '=', $codeD)->orWhere('sIDD', '=', $codeE)->count()==0)
//            &&(self::where('sIDE', '=', $codeA)->orWhere('sIDE', '=', $codeB)->orWhere('sIDE', '=', $codeC)->orWhere('sIDE', '=', $codeD)->orWhere('sIDE', '=', $codeE)->count()==0)
        )
        {
            $id=Self::create([
                'sIDA'=>$codeA,
                'sIDB'=>$codeB,
                'sIDC'=>$codeC,
                'sIDD'=>$codeD,
                'sIDE'=>$codeE,
                'eventID'=>$eventID
            ])->id;
            return ['id'=>$id,'code'=>$codeA.'-'.$codeB.'-'.$codeC.'-'.$codeD.'-'.$codeE];
        }
        else return false;
    }
    public static function generateCards($eventID,$number)
    {
        $cards=[];
        for($i=0;$i<$number;$i++){
            $card=false;
            while($card===false) {
                $card=Self::generateCard($eventID);
            }
            array_push($cards,$card);
        }
        return $cards;
    }
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
            ['sIDA', '=', $codeA],
            ['sIDB', '=', $codeB],
            ['sIDC', '=', $codeC],
            ['sIDD', '=', $codeD],
            ['sIDE', '=', $codeE]
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
