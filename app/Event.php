<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //create should create a user along with some accounts for the event
    //cash account is the 999_eventID_01
    protected $expensesAccount = 8;
    protected $cashAccount = 1;
    protected $promotionAccount = 9;
    protected $fillable = [
        'name', 'date', 'seats'
    ];
    protected $hidden = [
        'approvalID', 'requesterID', 'fillingStatus', 'visibility', 'filledSeats', 'updated_at', 'created_at', 'approvalDate', 'approvalStatus'
    ];

    public static function getAllEnrollable()
    {
        return self::where([
            ['visibility', '=', 1],
            ['approvalID', '>', 0],
            ['endDate', '>=', Carbon::now()],
//            ['events.filledSeats','<=','events.seats'],
            ['fillingStatus', '>', 0]
        ])->get();
    }

    public static function getAllTeamable()
    {
        return self::where([
            ['teaming', '=', 1],
            ['visibility', '=', 1],
            ['approvalID', '>', 0],
            ['endDate', '>=', Carbon::now()],
//            ['events.filledSeats','<=','events.seats'],
            ['fillingStatus', '>', 0]

        ])->get();
    }

    public static function getTodayEvent()
    {
        return self::where([
            ['visibility', '=', 1],
            ['approvalID', '>', 0],
            ['startDate', '<=', Carbon::now()],
//            ['events.filledSeats','<=','events.seats'],
            ['fillingStatus', '>', 0]
        ])->get();
    }

    public static function isNotExist($id)
    {
        if (Event::where('id', $id)->count() != 1)
            return true;
        else return false;
    }

    public static function isExist($id)
    {
        if (Event::where('id', $id)->count() == 1)
            return true;
        else return false;
    }

    public function requester()
    {
        return $this->hasOne('App\User');
    }

    public function approver()
    {
        return $this->hasOne('App\User');
    }

    public function venue()
    {
        return $this->hasMany('App\Venue');
    }

    public function participants()
    {
        return $this->hasMany('App\Enrollment');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function promotionIncentiveTransferRequest()
    {
        //should be queued
    }

    public function promotionIncentiveTransferNonRequest($coordinatorCollegeUID, $enrollmentTransactionID)
    {
        //its direct and requires no approval
        $promotionAccount = '999' . $this->id . '04';
        $narration = "Promotional CashBack of";
        if (User::ifNotExist($coordinatorCollegeUID)) return ['title' => 'Interface Error', 'error' => 'Kindly Contact the system administrator'];
        $coordinatorRate = User::find($coordinatorCollegeUID)->incentiveRate;
        if ($coordinatorRate > $this->maxIncentiveRate)
            $rate = $this->maxIncentiveRate;
        else $rate = $coordinatorRate;
        $amount = $this->ticketPrice * $rate;
        $narration .= " ₹" . $amount . " recived for $enrollmentTransactionID";
        //debit account for Promotion is 04
        return Transaction::directTransferDeQueue($promotionAccount, $coordinatorCollegeUID, $amount, $narration, 99887766);
    }

    public function saveNew(array $options = [])
    {
        $this->save($options);
        $this->createAccounts();
        $this->createDefaultTeams($this->id);
    }

    public function createAccounts()
    {
        $cashAccount = new Account();
        $cashAccount->name = $this->name . ' - Cash Account';
        $cashAccount->number = '999' . $this->id . '01';
        $cashAccount->type = 25;
        $cashAccount->balance=0;
        $cashAccount->collegeUID = 99887766;
        $cashAccount->createdBy = $this->requesterID;
        $cashAccount->save();
        $promotionAccount = new Account();
        $promotionAccount->name = $this->name . ' - Promotion Account';
        $promotionAccount->number = '999' . $this->id . '04';
        $promotionAccount->type = 25;
        $promotionAccount->balance=0;
        $promotionAccount->createdBy = $this->requesterID;
        $promotionAccount->collegeUID = 99887766;
        $promotionAccount->save();
        $expensesAccount = new Account();
        $expensesAccount->name = $this->name . ' - Expenses Account';
        $expensesAccount->number = '999' . $this->id . '02';
        $expensesAccount->type = 25;
        $expensesAccount->balance=0;
        $expensesAccount->createdBy = $this->requesterID;
        $expensesAccount->collegeUID = 99887766;
        $expensesAccount->save();
        $onlinePayments = new Account();
        $onlinePayments->name = $this->name . ' - Online Account';
        $onlinePayments->number = '999' . $this->id . '03';
        $onlinePayments->type = 25;
        $onlinePayments->createdBy = $this->requesterID;
        $onlinePayments->balance=0;
        $onlinePayments->collegeUID = 99887766;
        $onlinePayments->save();
    }

    public function createDefaultTeams($eventID)
    {
        $team = new Team();
        $team->name = 'Individual';
        $team->eventID = $eventID;
        $team->save();
    }
}
