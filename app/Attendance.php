<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Attendance extends Model
{
    //
    protected $table='attendance';
    protected $fillable=['attendeeUID','coordinatorUID','verified','verifiedBy','dateID','enrollmentID'];
//    protected $visible=['']

    public static function createRequest($validatedData,int $coordinatorID,$dateObject)
    {
        $date=$dateObject;
        $id=DB::transaction(function () use ($validatedData,$coordinatorID,$date){
            foreach ($validatedData['students'] as $student)
            {
                Attendance::create([
                    'attendeeUID'=>$student['collegeUID'],
                    'coordinatorUID'=>$coordinatorID,
                    'enrollmentID'=>$student['enrollmentID'],
                    'dateID'=>$validatedData['dateid'],
                ]);
            }
            $enrollmentID=$validatedData['students'][0]['enrollmentID'];
            $eventID=Enrollment::findOrFail($enrollmentID)->eventID;
            $date->attendanceState=true;
            $date->save();
            $q=new Queue();
            return $q->createAttendanceRequestDeTrans($coordinatorID,$eventID,System::defaultAttendanceRemarks(),"Attendance Approval");
        },20);
        return['result'=>'success',"id"=>$id];
    }



    public static function updateQueueAttendance($queueID)
    {
        $queue = Queue::findOrFail($queueID);
        if ($queue->type == 505 and $queue->visibility == 1) {
            return DB::transaction(function () use ($queue) {

                $queue->approvedBy = User::getCurrentAPIUser()['collegeUID'];
                $queue->isApproved = 0;
                $queue->visibility = 0;
                $queue->approveTimeRemarks = "Verified attendance";
                $queue->save();
                $currentUser = User::getCurrentAPIUser()['collegeUID'];
                $attendanceIDarr = DB::table('enrollments')->where('enrollments.eventID', (int)$queue->parameters)
                    ->join('users', 'enrollments.participantCollegeUID', '=', 'users.collegeUID')
                    ->join('accounts', 'enrollments.participantCollegeUID', '=', 'accounts.number')
                    ->join('teams', 'enrollments.teamID', '=', 'teams.id')
                    ->leftJoin('attendance', 'enrollments.id', '=', 'attendance.enrollmentID')
                    ->pluck('attendance.id')->all();
                DB::table('attendance')->whereIn('id', $attendanceIDarr)->update(['verified' => 1, 'verifiedBy' => $currentUser]);
                return [
                    'result' => 'success',
                    'message' => 'Attendance verified successfully'
                ];

            }, 5);
        }
        else{
                return ['result' => 'error'];
            }
        }

        public static function rejectAttendanceRequested($queueID){
            $queue = Queue::findOrFail($queueID);
            if ($queue->type == 505 and $queue->visibility == 1) {
                return DB::transaction(function () use ($queue) {
                    $queue->approvedBy = User::getCurrentAPIUser()['collegeUID'];
                    $queue->isApproved = 0;
                    $queue->visibility = 0;
                    $queue->approveTimeRemarks = "Verified attendance";
                    $queue->save();
                    $attendanceIDarr = DB::table('enrollments')->where('enrollments.eventID', (int)$queue->parameters)
                        ->join('users', 'enrollments.participantCollegeUID', '=', 'users.collegeUID')
                        ->join('accounts', 'enrollments.participantCollegeUID', '=', 'accounts.number')
                        ->join('teams', 'enrollments.teamID', '=', 'teams.id')
                        ->leftJoin('attendance', 'enrollments.id', '=', 'attendance.enrollmentID')
                        ->pluck('attendance.id')->all();
                    DB::table('attendance')->whereIn('id', $attendanceIDarr)->delete();
                    return [
                        'result' => 'success',
                        'message' => 'Attendance rejected successfully'
                    ];

                }, 5);
            }
            else{
                return [
                    'result' => 'error',
                    'message' => 'Attendance already rejected'
                ];
            }
        }
}
