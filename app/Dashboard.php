<?php

namespace App;

use App\Http\Controllers\UsersController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    public $user;

    public function getWeeklyEarningsRecord()
    {
        return Transaction::where([['receiver','=',$this->user['collegeUID']],['type','=',14],['created_at','>=',now()->subDays(7)]])->select('amount','created_at')->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y');
        });
    }
    public function getWeeklyEnrollments()
    {
        return Enrollment::where([['facilitatorCollegeUID','=',$this->user['collegeUID']],['created_at','>=',now()->subDays(7)]])->select('created_at')->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y');
        });
    }
    public function totalEarnings()
    {
        return Transaction::where([['receiver','=',$this->user['collegeUID']],['type','=',14]])->sum('amount');
    }
    /**
     * Returns the number of enrollments done by the user since the user entered into the organization
     * @return mixed
     */
    public function countTotalMonthlyEnrollments()
    {
        return Enrollment::where([['facilitatorCollegeUID','=',$this->user['collegeUID']],['created_at','>=',now()->subDays(31)]])
            ->select('created_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('d-m-Y');}
            );
    }
    public function totalMonthlyEnrollmentsDoneByOrganization()
    {
        return Enrollment::where([['created_at','>=',now()->subMonth(1)]])
            ->select('created_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('d-m-Y');}
            );
        ;
    }
    public function breadcumbData()
    {
        $user= User::getCurrentAPIUser();
        $account=Account::findOrFail($user['collegeUID']);
        return [
            'thisMonthEarnings'=>$this->totalEarnings(),
            'currentBalance'=>$account->balance,
            'thisWeekEarning'=>$this->getWeeklyEarningsRecord(),
            'thisWeekEnrollments'=>$this->getWeeklyEnrollments(),
            'totalEnrollmentsByOrganization'=>$this->totalMonthlyEnrollmentsDoneByOrganization(),
            'totalEnrollmentsDoneByUser'=>$this->countTotalMonthlyEnrollments(),
            'totalMembers'=>User::where([['authorityLevel','=',0]])->count(),
            'totalMembersIntroduced'=>User::where('referenceUID',User::getCurrentAPIUser()['collegeUID'])->count(),
            'totalCoordinators'=>User::where([['status','=',1],['authorityLevel','>',0]])->count(),
            'upcomingEvents'=>count(Event::getAllEnrollable()),
            'totalEvents'=>Event::count(),
            'rankings'=>$this->rankings(),
        ];
    }
    public function rankings(){
        $finarr=[];
        foreach (Event::getAllEnrollableIDs() as $event){
        $arr= Enrollment::where('eventID',$event)->select('facilitatorCollegeUID as id')->get()->groupBy(function ($e){
            return User::getNameFromCollegeUID($e->id);
        })->toArray();
        $map=[];
        foreach (array_keys($arr) as $val){
            $map+=[$val=>count($arr[$val])];
        }
        $name=Event::find($event)->name;
        $finarr+=[$name=>$map];
        }
        return $finarr;
    }
    public function getPersonalDashboard()
    {
        return[
            'totalEnrollmentsByOrganization'=>$this->totalMonthlyEnrollmentsDoneByOrganization(),
            'totalEnrollmentsDoneByUser'=>$this->countTotalMonthlyEnrollments(),

        ];
    }
}
