<?php

namespace App;

use App\Exceptions\SmartCardUtilException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class SmartCard extends Model
{
    protected $table="smartcards";
    protected $fillable=['sIDA','sIDB','sIDC','sIDD','sIDE','eventID','value'];
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
    private static function generateCard($eventID,$value)
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
        //optional start
            &&$codeA!=$codeB
            &&$codeA!=$codeC
            &&$codeA!=$codeD
            &&$codeA!=$codeE
            &&$codeB!=$codeC
            &&$codeB!=$codeD
            &&$codeB!=$codeE
            &&$codeC!=$codeD
            &&$codeC!=$codeE
            &&$codeD!=$codeE
            &&(self::where('sIDA', '=', $codeA)->orWhere('sIDA', '=', $codeB)->orWhere('sIDA', '=', $codeC)->orWhere('sIDA', '=', $codeD)->orWhere('sIDA', '=', $codeE)->count()==0)
            &&(self::where('sIDB', '=', $codeA)->orWhere('sIDB', '=', $codeB)->orWhere('sIDB', '=', $codeC)->orWhere('sIDB', '=', $codeD)->orWhere('sIDB', '=', $codeE)->count()==0)
            &&(self::where('sIDC', '=', $codeA)->orWhere('sIDC', '=', $codeB)->orWhere('sIDC', '=', $codeC)->orWhere('sIDC', '=', $codeD)->orWhere('sIDC', '=', $codeE)->count()==0)
            &&(self::where('sIDD', '=', $codeA)->orWhere('sIDD', '=', $codeB)->orWhere('sIDD', '=', $codeC)->orWhere('sIDD', '=', $codeD)->orWhere('sIDD', '=', $codeE)->count()==0)
            &&(self::where('sIDE', '=', $codeA)->orWhere('sIDE', '=', $codeB)->orWhere('sIDE', '=', $codeC)->orWhere('sIDE', '=', $codeD)->orWhere('sIDE', '=', $codeE)->count()==0)
        //optional end
        )
        {
            $id=Self::create([
                'sIDA'=>$codeA,
                'sIDB'=>$codeB,
                'sIDC'=>$codeC,
                'sIDD'=>$codeD,
                'sIDE'=>$codeE,
                'eventID'=>$eventID,
                'value'=>$value
            ])->id;
            return ['id'=>$id,'code'=>implode('-',[$codeA,$codeB,$codeC,$codeD,$codeE]),'value'=>$value];
        }
        else return false;
    }
    public static function generateCards($eventID,$number,$value)
    {
        $cards=[];
        for($i=0;$i<$number;$i++){
            $card=false;
            while($card===false) {
                $card=Self::generateCard($eventID,$value);
            }
            array_push($cards,$card);
        }
        return $cards;
    }
    public static function markUsed($couponID)
    {
        DB::table('smartcards')->where('id', '=', $couponID)->update(['used' => true]);
    }

    public function ifNotExist($codeA, $codeB, $codeC, $codeD, $codeE)
    {
        return !self::getIfExist($codeA, $codeB, $codeC, $codeD, $codeE);
    }

    public static function getIfExist($codeA, $codeB, $codeC, $codeD, $codeE)
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
            self::touched($id->firstOrFail()->id);
            return $id->firstOrFail();
        } else return false;
    }public static function getIfUnUtilizedExist($codeA, $codeB, $codeC, $codeD, $codeE)
    {
        $verifiedKeys = 0;
        $id = self::where([
            ['sIDA', '=', $codeA],
            ['sIDB', '=', $codeB],
            ['sIDC', '=', $codeC],
            ['sIDD', '=', $codeD],
            ['sIDE', '=', $codeE],
            ['used','=',0],
            ['isActive','=','1']
        ]);
        if ($id->count() == 1) {
            self::touched($id->id);
            return $id->firstOrFail();
        } else return false;
    }

    public static function touched($couponID)
    {
        DB::table('smartcards')->where('id', '=', $couponID)->update(['touched' => true]);
    }

    /**
     * @param $collegeID
     * @return bool
     * @throws SmartCardUtilException
     */
    public function redeemCard($collegeID){
        $this->used=1;
        $this->redeemTimeStamp=now();
        if($this->studentCollegeUID>0)
            throw new SmartCardUtilException($this,455);
        $this->isActive=0;
        $this->touched=1;
        $this->save();
        return true;
    }
}
