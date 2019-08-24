<?php

namespace App\Http\Controllers\API;

use App\Account;
use App\Enrollment;
use App\Event;
use App\Http\Requests\OnlinePaymentResponseRequest;
use App\Http\Requests\PayDuesToOrganizationRequest;
use App\Mail\EnrollmentReceipt;
use App\Mail\TransactionAlert;
use App\OnlinePayment;
use App\PendingPayment;
use App\System;
use App\Transaction;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OnlinePaymentController extends Controller
{
    public function paymentResponseActionEval(OnlinePaymentResponseRequest $request)
    {
        $validatedData = $request->validatedAndSanitized();
        return DB::transaction(function () use ($validatedData, $request) {
            $pendingPayment = PendingPayment::findOrFail($validatedData['ORDERID']);
            if ($request->validateTransaction($validatedData['ORDERID'])) {
                /*
                 * check if the request was not approved earlier
                 * check if the amount matching with the alloc amount in pending payments table
                 */
                if ($pendingPayment->approval == 1 || $pendingPayment->amount != $validatedData['TXNAMOUNT']) {
                    abort(422, 'Payment Approved and still PG sent response or amount is different');
                } else {
                    $opt = OnlinePayment::create($validatedData + ['request' => json_encode($request->headers->all()).'|'.json_encode($request->getContent()), 'verified' => true]);
                    $pendingPayment->approval = 1;
                    $pendingPayment->approvalTime = now();
                        $txID = Transaction::nonDBTransactionDeQueueTransfer(
                        $pendingPayment->debitAccountNumber,
                        $pendingPayment->creditAccountNumber,
                        $validatedData['TXNAMOUNT'],
                        'Online Payment using Payment Gateway',
                        99887766,
                        1,
                        55
                    );$txID2 = Transaction::nonDBTransactionDeQueueTransfer(
                        $pendingPayment->creditAccountNumber,
                        99887766,
                        $validatedData['TXNAMOUNT'],
                        'Payment for Online Enrollment',
                        99887766,
                        1,
                        55
                    );
                    $pendingPayment->remarks = "txID=$txID|txID2=$txID2|opID=" . $opt->id;
                    $pendingPayment->save();
                    $attr = explode('|', $pendingPayment->reference);
                    $action = $attr[0];
                    if ($action == "enrollment") {
                        $coorID = 99887766;
                        $participantCollegeUID = $pendingPayment->collegeUID;
                        $eventID = $attr[1];
                        $teamID = $attr[2];
                        $enrollment = new Enrollment();
                        $enrollment->eventID = $eventID;
                        //event online account ends with 03
                        $id = $enrollment->enrollWithFullPayment($participantCollegeUID, $coorID, $teamID, "03");
                        $enrollment->id = $id;
                        $user = User::where('collegeUID', $participantCollegeUID)->firstOrFail();
                        $event = Event::find($eventID);
                        $mailParams = array(
                            'subject' => 'Registration Successful - MegaMinds OMS',
                            'event' => $event,
                            'enrollment' => $enrollment,
                            'participant' => $user,
                            'coordinator' => ['firstName' => 'Online', 'lastName' => 'Gateway'],
                            'amount' => 'Rs. ' . $validatedData['TXNAMOUNT'],
                        );
                        System::mailer($user->email, new EnrollmentReceipt($mailParams));
                        return view('layouts.payments.success');
                    }elseif ($action=="op")
                    {
                        $user = User::where('collegeUID', $pendingPayment->collegeUID)->firstOrFail();
                        $txMailParams=array(
                            'closing'=>'Rs. '.Account::balance($pendingPayment->collegeUID),
                            'transactionID'=>$txID,
                            'assocID'=>$pendingPayment->collegeUID,
                            'type'=>'credit',
                            'amount'=>'Rs. '.$validatedData['TXNAMOUNT'],
                            'msg'=>"Online Payment Successful",
                            'subject'=>'Transaction Alert');
                        System::mailer($user->email,new TransactionAlert($txMailParams));
                        return view('layouts.payments.success');
                    }
                }
            } else {
                //some error in the response
                //we will store the response without performing any action
                $opt = OnlinePayment::create($validatedData + ['request' => json_encode($request->headers->all()).'|'.json_encode($request->getContent()), 'verified' => false]);
                $pendingPayment->approval = 0;
                $pendingPayment->save();
                return view('layouts.payments.failed');
            }
        });
    }
    public function payDuesToOrganization(PayDuesToOrganizationRequest $request){
        $validated=$request->validatedAndSanitized();
        $amt=(int)$validated['amount'];
        $uid=User::getCurrentAPIUser()['collegeUID'];
        $pendingPayments=PendingPayment::create([
            'collegeUID'=>$uid,
            'transactionID'=>'gen_'.System::randAlphaNum(12),
            'amount'=>$amt,
            'debitAccountNumber'=>System::getPropertyValueByName('accounts_org_digi-cash_paytm'),
            'creditAccountNumber'=>$uid,
            'reference'=>'op|',
        ]);
        $onlinePayment = new OnlinePayment();
        $user=User::where('collegeUID',$uid)->firstOrFail();
        return $onlinePayment->addMoneyRequest($pendingPayments->id,$user,$amt);
    }
}
