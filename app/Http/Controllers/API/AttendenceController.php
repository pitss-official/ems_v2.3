<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\Eventdate;
use App\Exceptions\AttendanceException;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Queue;
use Illuminate\Http\Request;

class AttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentLevel = User::getCurrentAPIUser()['level'];
        return Queue::where([
            ['type', 505],
            ['authenticationLevel','<=',$currentLevel],
            ['isApproved','!=',1],
            ['visibility','!=',0]])->get();

    }

    public function getAttendanceList(int $eventID){

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


    public function getAllEnrolledStudents(int $eventID)
    {
        return DB::table('enrollments')->where('enrollments.eventID',$eventID)
            ->join('users','enrollments.participantCollegeUID','=','users.collegeUID')
            ->join('accounts','enrollments.participantCollegeUID','=','accounts.number')
            ->join('teams','enrollments.teamID','=','teams.id')
            ->select('users.firstName','users.middleName','users.lastName','users.collegeUID','users.school','users.branch','accounts.balance','teams.name as teamName','enrollments.id')
            ->orderBy('teams.name','asc')
            ->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeRequest(Request $request)
    {
        $validatedData=$request->validate([
            'headcount'=>'required|integer|min:0',
            'students.*.collegeUID'=>'required|exists:enrollments,participantCollegeUID|numeric|digits:8',
            'dateid'=>'required|numeric|exists:eventdates,id|min:1',
            'students.*.enrollmentID'=>'required|numeric|exists:enrollments,id',
            'students.*.collegeUID'=>'required|numeric|digits:8|exists:users,collegeUID',
        ]);

        $date=Eventdate::findOrFail($validatedData['dateid']);
//        if($date->attendanceState==true)
//            throw new AttendanceException("Attendance already marked for this date and is sent for verification");
        if(!isset($validatedData['students']) & $validatedData['headcount']==0){
            $date->attendanceState=true;
            $date->save();
            return['result'=>'success'];
        }
        if(isset($validatedData['students']))
        if($validatedData['headcount']==count($validatedData['students'])){
            $coordinatorID=User::getCurrentAPIUser()['collegeUID'];
            return Attendance::createRequest($validatedData,$coordinatorID,$date);
        } throw new AttendanceException("Headcount Mismatch");

    }

    public function verifyAttendance(Request $request){
        $validatedData = $request->validate([
            'id'=> 'required|numeric|exists:queues,id',
        ]);
        return Attendance::updateQueueAttendance($validatedData['id']);
    }

    public function rejectAttendance(Request $request){
        $validatedData = $request->validate([
            'queueID'=> 'bail|required|integer|min:0|exists:queues,id',
        ]);

        return Attendance::rejectAttendanceRequested($validatedData['queueID']);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
