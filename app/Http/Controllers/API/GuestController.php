<?php

namespace App\Http\Controllers\API;

use App\Account;
use App\Enrollment;
use App\Event;
use App\Exceptions\EnrollmentException;
use App\Mail\EnrollmentReceipt;
use App\OnlinePayment;
use App\PendingPayment;
use App\SmartCard;
use App\System;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    //
    public function events()
    {
        return Event::getAllEnrollable();
    }

    public function register(Request $request)
    {
        $validatedData = System::sanitize($request->validate([
            'event' => 'bail|required|integer|exists:events,id',
            'regid' => 'bail|required|numeric|digits:8',
            'team' => 'bail|nullable|integer|exists:teams,id,eventID,'.$request->event,
            'smartMode'=>'bail|required|integer',
        ]));

        return DB::transaction(function () use ($validatedData, $request) {
            if (User::isNotExist($validatedData['regid'])) {
                $validatedData = array_merge(System::sanitize($request->validate([
                    'email' => 'bail|required|email',
                    'course' => 'bail|required|string|min:3|max:255',
                    'school' => 'bail|required|string|min:1|max:2',
                    'fathersName' => 'nullable|string|min:1|max:100',
                    'firstName' => 'bail|required|string|min:1|max:25',
                    'middleName' => 'nullable|string|min:1|max:25',
                    'lastName' => 'nullable|string|min:1|max:25',
                    'mobile' => 'bail|required|numeric|digits:10|unique:users',
                    'whatsapp' => 'nullable|numeric|digits:10',
                    'gender' => 'bail|required|integer|digits_between:0,3',
                    'address' => 'nullable|string|max:250',
                    'country' => 'nullable|string|max:5',
                    'birthday' => 'nullable|date',
                ])), $validatedData);
                $request->validate([
                    'email' => 'unique:users,email',
                    'mobile' => 'unique:users,mobile',
                    'regid' => 'unique:users,collegeUID',
                ]);
                $user = new User();
                $password = System::randAlphaNum(10);
                $user->firstName = $validatedData['firstName'];
                $user->middleName = $validatedData['middleName'];
                $user->lastName = $validatedData['lastName'];
                $user->collegeUID = $validatedData['regid'];
                $user->gender = $validatedData['gender'];
                $user->school = $validatedData['school'];
                $user->branch = $validatedData['course'];
                if ($validatedData['country'] == null)
                    $validatedData['country'] = 'IN';
                $user->nationality = $validatedData['country'];
                $user->mobile = $validatedData['mobile'];
                $user->altMobile = $validatedData['whatsapp'];
                $user->email = $validatedData['email'];
                $user->fathersName = $validatedData['fathersName'];
                $user->createdBy = 99887766;
                $user->password = \Illuminate\Support\Facades\Hash::make($password);
                $user->status = 0;
                $user->referenceUID = 99887766;
                $user->save();
                try {
                    $user->openAccount();
                } catch (\Exception $e) {
                    abort(429,"Exception ".$e->getMessage());
                } finally {
                    if (Account::ifNotExist($user->collegeUID)) {
                        $user->delete();
                        throw new EnrollmentException("Account Creation Failed, Data has been rolled back");
                    }
                }
            }
            $validatedData['collegeUID']=$validatedData['regid'];
            $user = User::where('collegeUID', $validatedData['regid'])->firstOrFail();
            $event = Event::findOrFail($validatedData['event']);
            if($validatedData['smartMode']==0){
                $validatedData= array_merge(System::sanitize($request->validate([
                    'smartCode.*'=>'required|alpha_num|min:5|max:5'
                ])),$validatedData);
                $card=SmartCard::getIfExist(
                    $validatedData['smartCode']['A'],
                    $validatedData['smartCode']['B'],
                    $validatedData['smartCode']['C'],
                    $validatedData['smartCode']['D'],
                    $validatedData['smartCode']['E']);
                if($card!=false)
                {
                        $card->redeemCard($validatedData['collegeUID']);
                    if($card->value>=$event->ticketPrice){

                        $txID = Transaction::nonDBTransactionDeQueueTransfer(
                            System::getPropertyValueByName('accounts_org_smartcard_account'),
                            $validatedData['collegeUID'],
                            $card->value,
                            'Smart Card Redeemed',
                            99887766,
                            1,
                            598
                        );

                        $txID2 = Transaction::nonDBTransactionDeQueueTransfer(
                            $validatedData['collegeUID'],
                            99887766,
                            $event->ticketPrice,
                            'Payment for Online Enrollment into '.$event->name,
                            99887766,
                            1,
                            567
                        );

                        $coorID = 99887766;

                        $eventID = $event->id;
                        //todo implement teams
                        $teamID =11;
                        $enrollment = new Enrollment();
                        $enrollment->eventID = $eventID;
                        //event online account ends with 03
                        $id = $enrollment->enrollWithFullPayment($validatedData['collegeUID'], $coorID, $teamID, "03");
                        $enrollment->id = $id;
                        $user = User::where('collegeUID', $validatedData['collegeUID'])->firstOrFail();
                        $mailParams = array(
                            'subject' => 'Registration Successful - MegaMinds OMS',
                            'event' => $event,
                            'enrollment' => $enrollment,
                            'participant' => $user,
                            'coordinator' => ['firstName' => 'Smart Card ID:'.$card->id, 'lastName' => ''],
                            'amount' => 'Rs. ' .$card->value,
                        );

                        System::mailer($user->email, new EnrollmentReceipt($mailParams));

                        return [
                            'result'=>'success',
                            'data'=>null,
                            'cardValue'=>$card->value,
                            'ticketCost'=>$event->ticketPrice,
                            'eid'=>$id,
                            ];
                    }else{
                        $txID = Transaction::nonDBTransactionDeQueueTransfer(
                            System::getPropertyValueByName('accounts_org_smartcard_account'),
                            $validatedData['collegeUID'],
                            $card->value,
                            'Smart Card Redeemed',
                            99887766,
                            1,
                            598
                        );
                        $pendingPayments=PendingPayment::create([
                            'collegeUID'=>$validatedData['regid'],
                            'transactionID'=>'prm_ptm'.System::randAlphaNum(12,false),
                            'amount'=>$event->ticketPrice-$card->value,
                            'debitAccountNumber'=>System::getPropertyValueByName('accounts_org_digi-cash_paytm'),
                            'creditAccountNumber'=>$validatedData['regid'],
//            'reference'=>'enrollment|'.$validatedData['event'].'|'.$validatedData['team'],
                            'reference'=>'enrollment|'.$validatedData['event'].'|'.'11',
                        ]);
                        $onlinePayment = new OnlinePayment();
                        return [
                            'result'=>'success',
                            'data'=>$onlinePayment->initiateRequest($pendingPayments->id, $user, $event->ticketPrice),
                            'cardValue'=>$card->value,
                            'payValue'=>$event->ticketPrice-$card->value,
                            'ticketCost'=>$event->ticketPrice,
                        ];
                    }
                }else{
                    return ['result'=>'error','reason'=>'Card is in Invalid,Used or Locked state'];
                };
//                System::mailer($validatedData['email'],new );
            }else{
            $pendingPayments=PendingPayment::create([
                'collegeUID'=>$validatedData['regid'],
                'transactionID'=>'ptm_'.System::randAlphaNum(12,false),
                'amount'=>$event->ticketPrice,
                'debitAccountNumber'=>System::getPropertyValueByName('accounts_org_digi-cash_paytm'),
                'creditAccountNumber'=>$validatedData['regid'],
//            'reference'=>'enrollment|'.$validatedData['event'].'|'.$validatedData['team'],
                'reference'=>'enrollment|'.$validatedData['event'].'|'.'11',
            ]);
            $onlinePayment = new OnlinePayment();
            return $onlinePayment->initiateRequest($pendingPayments->id, $user, $event->ticketPrice);
            }
        });
    }
}
