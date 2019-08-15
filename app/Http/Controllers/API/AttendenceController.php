<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\Eventdate;
use App\Exceptions\AttendanceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRejectRequest;
use App\Http\Requests\AttendanceStoreRequest;
use App\Http\Requests\AttendanceVerifyRequest;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Queue;
use Illuminate\Http\Request;

class AttendenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /** Verify Attendance
     * @return mixed
     */
    public function index()
    {
        $this->authorize('verify',Attendance::class);
        $currentLevel = User::getCurrentAPIUser()['level'];
        return Queue::where([
            ['type', 505],
            ['authenticationLevel','<=',$currentLevel],
            ['isApproved','!=',1],
            ['visibility','!=',0]])->get();
    }
    public function getAttendanceList(int $eventID)
    {
        $this->authorize('verify',Attendance::class);
        return DB::table('enrollments')->where('enrollments.eventID',$eventID)
            ->join('users','enrollments.participantCollegeUID','=','users.collegeUID')
            ->join('accounts','enrollments.participantCollegeUID','=','accounts.number')
            ->join('teams','enrollments.teamID','=','teams.id')
            ->leftJoin('attendance','enrollments.id','=','attendance.enrollmentID')
            ->select('users.firstName','users.middleName','users.lastName','users.collegeUID','users.school','users.branch',
                'accounts.balance','teams.name as teamName','enrollments.id','attendance.id as attendanceID')
            ->orderBy('teams.name','asc')
            ->get();
    }

    /**
     * @param int $eventID
     * @ability mark:attendance
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getAllEnrolledStudents(int $eventID)
    {
        $this->authorize('mark',Attendance::class);
        return DB::table('enrollments')->where('enrollments.eventID',$eventID)
            ->join('users','enrollments.participantCollegeUID','=','users.collegeUID')
            ->join('accounts','enrollments.participantCollegeUID','=','accounts.number')
            ->join('teams','enrollments.teamID','=','teams.id')
            ->select('users.firstName','users.middleName','users.lastName','users.collegeUID','users.school','users.branch','accounts.balance','teams.name as teamName','enrollments.id')
            ->orderBy('teams.name','asc')
            ->get();
    }

    /**
     * @param AttendanceStoreRequest $request
     * @return array
     */
    public function storeRequest(AttendanceStoreRequest $request)
    {
        $validatedData=$request->validatedAndSanitized();
        $date=Eventdate::findOrFail($validatedData['dateid']);
        if($date->attendanceState==true)
            abort(422,"Attendance already marked for this date and is sent for verification");
        if(!isset($validatedData['students']) & $validatedData['headcount']==0){
            $date->attendanceState=true;
            $date->save();
            return['result'=>'success'];
        }
        if(isset($validatedData['students']))
        if($validatedData['headcount']==count($validatedData['students'])){
            $coordinatorID=User::getCurrentAPIUser()['collegeUID'];
            return Attendance::createRequest($validatedData,$coordinatorID,$date);
        } return ['result'=>'error','message'=>'Headcount Mismatch'];
    }
    public function verifyAttendance(AttendanceVerifyRequest $request){
        $validatedData = $request->validatedAndSanitized();
        return Attendance::updateQueueAttendance($validatedData['id']);
    }
    public function rejectAttendance(AttendanceRejectRequest $request){
        $validatedData = $request->validatedAndSanitized();
        return Attendance::rejectAttendanceRequested($validatedData['queueID']);
    }
}
