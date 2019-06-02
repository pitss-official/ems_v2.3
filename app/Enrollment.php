<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Enrollment extends Model
{
    //
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'bloodGroup',
        'nationality',
        'eventID',
        'collegeUID',

    ];
    protected $visible = [''];

    public static function getAllStudents($eventID)
    {
        return Enrollment::where('eventID', $eventID);
    }

    public static function ifNotExist($id)
    {
        if (self::where('id', $id)->count() != 1)
            return true;
        else return false;
    }

    public static function isExist($id)
    {
        if (self::where('id', $id)->count() == 1)
            return true;
        else return false;
    }

    public function transactions()
    {
        return $this->hasMany('App\Transactions');
    }

    public function beneficiary()
    {
        return $this->hasOne('App\User');
    }

    public function initiator()
    {
        return $this->hasOne('App\User');
    }

    public function enrollWithFullPayment($enrollingStudentCollegeUID, $coordinatorCollegeUID, $teamID)
    {
        //Vaidation
        /*
         * Check if the clientID is Valid
         */
            if (User::ifNotExist($enrollingStudentCollegeUID) || User::ifNotExist($coordinatorCollegeUID))
                return ['title' => 'Invalid RoR', 'error' => 'Cannot perform a transaction since either the Recipient or the user doesnt have accounts'];
            /*
             * Step 1 : Create a New user with Parameters through user controller
             * This Step should be already implemented in the system before reaching this step
             */
            //PROCEDURE START FROM HERE
            /*
             * Step 2 : Find the requested event and fetch the assoc. price
             */

            $event = Event::find($this->eventID);
            //TRANSACTION BEGIN
            $coordinatorAccount = DB::table('accounts')->where('number', '=', $coordinatorCollegeUID);
            return DB::transaction(function () use ($event, $teamID, $coordinatorCollegeUID, $enrollingStudentCollegeUID) {
                //eventCashAccount Begins with EVENTID_0_1
                $eventCashAccount = '999' . $this->eventID . "01";

                $amount = $event->ticketPrice;
                $eventNarration = "Enrollment successful for $enrollingStudentCollegeUID by $coordinatorCollegeUID";
                $narration = "Enrollment Fees for " . $event->name . ' transferred by ' . $coordinatorCollegeUID;
                /*
                 * Step 2 : Debit the coordinator account Credit to Student Account along with record in the transaction
                 */
                $studentCreditTransactionID = Transaction::nonDBTransactionDeQueueTranfer($coordinatorCollegeUID, $enrollingStudentCollegeUID, $amount, $narration, $coordinatorCollegeUID, 1);
                /*
                 * Step 3: Create a Transaction : Debit from Student Account as Registration Fees of the Event
                 */
            $eventCashCreditTransactionID = Transaction::nonDBTransactionDeQueueTranfer($enrollingStudentCollegeUID, $eventCashAccount, $amount, $eventNarration, $coordinatorCollegeUID, 1);
            /*
             * Step 4: Insert a Record in Enrollments
             */
            $enrollmentID = DB::table('enrollments')->insertGetId(
                [
                    'participantCollegeUID' => $enrollingStudentCollegeUID,
                    'facilitatorCollegeUID' => $coordinatorCollegeUID,
                    'eventID' => $this->eventID,
                    'fundTransactionID' => $studentCreditTransactionID,
                    'enrollmentFeesTransactionID' => $eventCashCreditTransactionID,
                    'created_at' => Carbon::now(),
                    'partialPay' => 0
                ]
            );
            /*
             * Step 5: Reduce the number of avl seats in the events entry
             */
            $currentlyFilled = DB::table('events')->where('id', '=', $this->eventID)->value('filledSeats');
            DB::table('events')->where('id', '=', $this->eventID)->update(['filledSeats' => $currentlyFilled + 1]);
            /*
             * Step 6: reduce the availablity in the team return the Transaction Enrollment ID
             */
            Team::reduceVacancyNonTransaction($teamID);
            return $enrollmentID;
        }, 5);
    }

    public function reserveSeatViaPartialPayment($enrollingStudentCollegeUID, $coordinatorCollegeUID, $amount, $teamID)
    {
        $amount = floatval($amount);
        if (User::isNotExist($enrollingStudentCollegeUID) || User::isNotExist($coordinatorCollegeUID))
            return ['title' => 'Invalid RoR', 'error' => 'Cannot perform a transaction since either the Recipient or the user doesnt have accounts'];
        $event = Event::find($this->eventID);
        $minimumAmountToPay = $event->minimumPayment * $event->ticketPrice / 100;
        if ($amount < $minimumAmountToPay) return ['title' => 'Cannot Reserve Seat', 'error' => 'The amount is lesser than Allowed'];
        else {
            return DB::transaction(function () use ($amount, $event, $enrollingStudentCollegeUID, $coordinatorCollegeUID, $teamID) {
                if ($teamID > 0) {
                    Team::reduceVacancyNonTransaction($teamID);
                }
                /*
                 * Step 1: Transfer requested amount from the coordinator account to the student account
                 */

                $coordinatorNarration = "Money Transfer for enrollment in " . $event->name . ' with pending payment of ₹' . (floatval($event->ticketPrice) - $amount);
                $studentCreditTransactionID = Transaction::nonDBTransactionDeQueueTranfer($coordinatorCollegeUID, $enrollingStudentCollegeUID, $amount, $coordinatorNarration, $coordinatorCollegeUID, 1);
                /*
                 * Step 2: Transfer full amount from the student account to event cash account
                 */
                $eventNarration = "Enrollment successful for $enrollingStudentCollegeUID by $coordinatorCollegeUID using PartialPay";
                $eventCashAccount = '999' . $this->eventID . '01';
                $eventCashCreditTransactionID = Transaction::nonDBTransactionDeQueueTranfer($enrollingStudentCollegeUID, $eventCashAccount, $event->ticketPrice, $eventNarration, $coordinatorCollegeUID, 1);
                /*
                 * Step 3: Create a new enrollment record and return the enrollment ID
                 */
                var_dump([$studentCreditTransactionID,$eventCashCreditTransactionID]);
                $enrollmentID = DB::table('enrollments')->insertGetId(
                    [
                        'participantCollegeUID' => $enrollingStudentCollegeUID,
                        'facilitatorCollegeUID' => $coordinatorCollegeUID,
                        'eventID' => $this->eventID,
                        'fundTransactionID' => $studentCreditTransactionID,
                        'enrollmentFeesTransactionID' => $eventCashCreditTransactionID,
                        'created_at' => Carbon::now(),
                        'partialPay' => 1
                    ]
                );
                /*
                 * Step 4: Reduce the vacancy in the team
                 */
                Team::reduceVacancyNonTransaction($teamID);
                /*
                 * Step 5: Reduce the number of avl seats in the events entry
                 */
                $currentlyFilled = DB::table('events')->where('id', '=', $this->eventID)->value('filledSeats');
                DB::table('events')->where('id', '=', $this->eventID)->update(['filledSeats' => $currentlyFilled + 1]);
                return $enrollmentID;
            }
                , 5);
        }
    }
    public function refundRequestInitiate($enrollmentID)
    {

    }
}
