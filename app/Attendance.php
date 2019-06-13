<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Attendance extends Model
{
    //
    protected $table='attendance';
    protected $fillable=['eventID','attendeeUID','coordinatorUID','verified','verifiedBy','dateID'];
//    protected $visible=['']

    public static function createRequest($validatedData,int $coordinatorID,$dateObject)
    {
        $date=$dateObject;
        $id=DB::transaction(function () use ($validatedData,$coordinatorID,$date){
            $presentees=[];
            foreach ($validatedData['students'] as $student)
                array_push($presentees,Attendance::create([
                    'attendeeUID'=>$student['collegeUID'],
                    'coordinatorUID'=>$coordinatorID,
                    'enrollmentID'=>$student['enrollmentID'],
                    'dateID'=>$validatedData['dateid'],
                ])->id);
            $date->attendanceState=true;
            $date->save();
            $q=new Queue();
            return $q->createAttendanceRequestDeTrans($coordinatorID,$presentees,System::defaultAttendanceRemarks(),"Attendance Approval");
        },20);
        return['result'=>'success',"id"=>$id];
    }
}
