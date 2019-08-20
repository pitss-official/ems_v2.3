<?php

namespace App\Http\Controllers\API;

use App\Account;
use App\Enrollment;
use App\Event;
use App\Exceptions\EnrollmentException;
use App\Http\Controllers\Controller;
use App\Mail\EnrollmentReceipt;
use App\Mail\TransactionAlert;
use App\System;
use App\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function store(Request $request)
    {
        $this->authorize('enroll',Enrollment::class);
        //only for coordinator based enrollment
        $validatedData = System::sanitize($request->validate([
            'eventID' => 'bail|required|integer|exists:events,id',
            'collegeUID' => 'bail|required|unique:enrollments,participantCollegeUID,eventID' . $request->eventID . '|digits:8|numeric',
            'amount' => 'required|numeric|min:0',
            'team' => 'bail|nullable|integer|exists:teams,id,eventID,' . $request->eventID,
        ]));
        $coordinatorEmail=User::getCurrentAPIUser()['email'];
        $coordinatorUID = User::getCurrentAPIUser()['collegeUID'];
        if (User::isNotExist($validatedData['collegeUID'])) {
            $validatedData=array_merge(System::sanitize($request->validate([
                'email' => 'bail|required|email',
                'course'=>'bail|required|string|min:3|max:255',
                'school'=>'bail|required|string|min:1|max:2',
                'fathersName' => 'nullable|string|min:1|max:100',
                'firstName' => 'bail|required|string|min:1|max:25',
                'middleName' => 'nullable|string|min:1|max:25',
                'lastName' => 'nullable|string|min:1|max:25',
                'mobile' => 'bail|required|numeric|digits:10',
                'altMobile' => 'nullable|integer|digits:10|unique:users',
                'gender' => 'bail|required|integer|digits_between:0,3',
                'address' => 'nullable|string|max:250',
                'nationality' => 'bail|required|string|max:5',
                'bloodGroup' => 'nullable|string|max:5',
                'birthday' => 'nullable|date',
            ])),$validatedData);
            $request->validate([
                'email' => 'unique:users,email',
                'mobile' => 'unique:users,mobile',
                'collegeUID' => 'unique:users,collegeUID',
            ]);
            $user = new User();
            $user->firstName = $validatedData['firstName'];
            $user->middleName = $validatedData['middleName'];
            $user->lastName = $validatedData['lastName'];
            $user->collegeUID = $validatedData['collegeUID'];
            $user->gender = $validatedData['gender'];
            $user->school=$validatedData['school'];
            $user->branch=$validatedData['course'];
            $user->address = $validatedData['address'];
            if ($validatedData['nationality'] == null)
                $validatedData['nationality'] = 'IN';
            $user->nationality = $validatedData['nationality'];
            $user->bloodGroup = $validatedData['bloodGroup'];
            $user->birthday = $validatedData['birthday'];
            $user->mobile = $validatedData['mobile'];
            $user->altMobile = $validatedData['altMobile'];
            $user->email = $validatedData['email'];
            $user->fathersName = $validatedData['fathersName'];
            $user->createdBy = $coordinatorUID;
            $user->password = \Illuminate\Support\Facades\Hash::make(random_bytes(10));
            $user->status = 0;
            $user->referenceUID = $coordinatorUID;
            $user->save();
            try{
                    $user->openAccount();
            }
            catch(\Exception $e){
                echo "Exception";
            }
            finally {
                if (Account::ifNotExist($user->collegeUID))
                {
                    $user->delete();
                    throw new EnrollmentException("Account Creation Failed, Data has been rolled back");
                }
            }
        }else{
            $user=User::where('collegeUID',$validatedData['collegeUID'])->firstOrFail();
        }
        $enrollment = new Enrollment();
        $enrollment->eventID = $validatedData['eventID'];
        $event = Event::findOrFail($validatedData['eventID']);
        if($validatedData['amount']>$event->ticketPrice)$validatedData['amount']=$event->ticketPrice;
        if ($validatedData['amount'] >= $event->ticketPrice) {
            $id=$enrollment->enrollWithFullPayment((int)$validatedData['collegeUID'], $coordinatorUID, $validatedData['team']);
            $event->promotionIncentiveTransferNonRequest($id);
        } elseif ($validatedData['amount'] >= ($event->minimumPayment * $event->ticketPrice / 100)) {
            $id=$enrollment->reserveSeatViaPartialPayment((int)$validatedData['collegeUID'], $coordinatorUID, $validatedData['amount'], $validatedData['team']);
            $event->promotionIncentiveTransferRequest($id);
        } else {
            return ["result"=>'error','error' => 'Invalid Amount', 'message' => 'Kindly enter a valid amount to proceed'];
        }
        if($id>0){
            $enrollment=Enrollment::findOrFail($id);
            $mailParams=array(
                'subject'=>'Registration Successful - MegaMinds OMS',
                'event'=>$event,
                'enrollment'=>$enrollment,
                'participant'=>$user,
                'coordinator'=>User::getCurrentAPIUser(),
                'amount'=>'Rs. '.$validatedData['amount'],
            );
            $txMailParams=array(
                'closing'=>'Rs. '.Account::balance($coordinatorUID),
                'transactionID'=>$mailParams['enrollment']->id,
                'assocID'=>$user->collegeUID,
                'type'=>'debit',
                'amount'=>'Rs. '.$validatedData['amount'],
                'msg'=>"Enrollment for ".$validatedData['collegeUID']." Successful",
                'subject'=>'Transaction Alert');
            System::mailer($user->email,new EnrollmentReceipt($mailParams),['cc'=>$coordinatorEmail]);
            System::mailer($coordinatorEmail,new TransactionAlert($txMailParams));
        }
        return ["result"=>'success',"id"=>$id];
    }
    public function verify(int $id)
    {
        $i=0;
        try{
        $i= (int)Enrollment::isExist($id);}
        catch(\Exception $exception)
        {
            die("error");
        }finally
        {
            return $i;
        }
    }
}
