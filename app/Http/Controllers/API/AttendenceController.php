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
//        return Queue::where([
//            ['type', 505],
//            ['authenticationLevel','<=',$currentLevel],
//            ['isApproved','!=',1],
//            ['visibility','!=',0]])->get();
        return DB::table('enrollments')->where('enrollments.eventID',8)
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
//            throw new AttendanceException("Attendence already marked for this date and is sent for verification");
        if(!isset($validatedData['students'])){
            $date->attendanceState=true;
            $date->save();
            return['result'=>'success'];
        }
        if($validatedData['headcount']!=count($validatedData['students']))
            throw new AttendanceException("Headcount Mismatch");
        else{
            $coordinatorID=User::getCurrentAPIUser()['collegeUID'];
            return Attendance::createRequest($validatedData,$coordinatorID,$date);
        }

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
