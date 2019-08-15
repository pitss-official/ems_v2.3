<?php

namespace App\Http\Controllers\API;
use App\Account;
use App\Event;
use App\Exceptions\EnrollmentException;
use App\System;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuestController extends Controller
{
    public function test()
    {
        $e= Event::find(8);
        return $e->promotionIncentiveTransferRequest(19);
    }

    //
    public function events()
    {
        return Event::getAllEnrollable();
    }
    public function register(Request $request)
    {
        $validatedData = System::sanitize($request->validate([
            'event' => 'bail|required|integer|exists:events,id',
            'regid' => 'bail|required|unique:enrollments,participantCollegeUID,eventID' . $request->eventID . '|digits:8|numeric',
            'team' => 'bail|nullable|integer|exists:teams,id,eventID,' . $request->eventID,
        ]));
        if (User::isNotExist($validatedData['regid'])) {
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
                'nationality' => 'nullable|string|max:5',
                'bloodGroup' => 'nullable|string|max:5',
                'birthday' => 'nullable|date',
            ])),$validatedData);
            $request->validate([
                'email' => 'unique:users,email',
                'mobile' => 'unique:users,mobile',
                'regid' => 'unique:users,collegeUID',
            ]);
            $user = new User();
            $password=System::randAlphaNum(10);
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
            $user->createdBy = 99887766;
            $user->password = \Illuminate\Support\Facades\Hash::make($password);
            $user->status = 1;
            $user->referenceUID = 99887766;
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
        }

//        $enrollment = new Enrollment();
//        $enrollment->eventID = $validatedData['eventID'];
//        $event = Event::findOrFail($validatedData['eventID']);
//        if ($validatedData['amount'] >= $event->ticketPrice) {
//            return ["result"=>'success',"id"=>$enrollment->enrollWithFullPayment((int)$validatedData['collegeUID'], $coordinatorUID, $validatedData['team'])];
//
//        }elseif ($validatedData['amount'] >= ($event->minimumPayment * $event->ticketPrice / 100)) {
//            return $enrollment->reserveSeatViaPartialPayment((int)$validatedData['collegeUID'], $coordinatorUID, $validatedData['amount'], $validatedData['team']);
//        } else {
//            return ["result"=>'error','error' => 'Invalid Amount', 'message' => 'Kindly enter a valid amount to proceed'];
//        }
    }
}
