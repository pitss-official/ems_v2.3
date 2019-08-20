<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
        return Enrollment::where([['facilitatorCollegeUID','=',$this->user['collegeUID']],['created_at','>=',now()->subMonth(1)]])
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
            'totalEnrollmentsDoneByUser'=>$this->countTotalMonthlyEnrollments()
        ];
    }
    public function getPersonalDashboard()
    {
        return[
          'totalEnrollmentsByOrganization'=>$this->totalMonthlyEnrollmentsDoneByOrganization(),
          'totalEnrollmentsDoneByUser'=>$this->countTotalMonthlyEnrollments()
        ];
    }
}
