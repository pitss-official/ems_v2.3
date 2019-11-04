<?php

namespace App\Http\Controllers\API;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlowCreateForStudentRequest;
use App\Http\Requests\DoubleEntryTransactionRequest;
use App\Http\Requests\TransactionSearchRequest;
use App\System;
use App\Transaction;
use App\User;

class CashFlowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * transferring money from Coordinator to Enrolling Student
     * Step 1 : Check the limit of the user;
     * Step 2 : Check if the recipient is allowed for direct transfer
     * Step 3 : Perform nonQueue Transfer
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(CashFlowCreateForStudentRequest $request)
    {
        $coordinatorID = User::getCurrentAPIUser()['collegeUID'];
        $validatedData = $request->validatedAndSanitized();
        if ($this->negativeStudentAccountBalance($validatedData['collegeUID'])['balance'] >= 0) {
            return ["result"=>'error','message'=>"The recipient has non-negative balance or is inaccessible for you. <br><hr><b>Transaction Truncated</b>"];
        }
        return Transaction::directTransferDeQueue($coordinatorID, $validatedData['collegeUID'], $validatedData['amount'], 'Direct Cash Deposit/Transfer by ' . $coordinatorID, $coordinatorID);
    }

        public function negativeStudentAccountBalance($collegeUID)
        {
            $ac = Account::findOrFail($collegeUID)->makeVisible(['balance']);
            if ($ac->type != 0 || $ac->balance >= 0 )
                return ['balance' => 0];
            return ['balance' => $ac->balance];
        }
    public function search(TransactionSearchRequest $request)
    {
        $validatedData=$request->validatedAndSanitized();
        $this->authorize('search',Transaction::class);
        $retObj=Transaction::where('id','<',0);

        if($validatedData['transactionID']!=null)
        {
            $retObj=$retObj->orWhere('id',$validatedData['transactionID']);
        }
        if($validatedData['name']!=null)
        {
            $user=User::where('firstName','like',$validatedData['name'])->first()->collegeUID;
            $validatedData['collegeUID']=$user;
//            $retObj=$retObj->orWhere('id',$validatedData['transactionID']);
        }
        if($validatedData['collegeUID']!=null)
        {
            $retObj=$retObj->orWhere('receiver',$validatedData['collegeUID'])
            ->orWhere('sender',$validatedData['collegeUID']);
        }if($validatedData['accountNumber']!=null)
        {
            $retObj=$retObj->orWhere('receiver',$validatedData['accountNumber'])
            ->orWhere('sender',$validatedData['accountNumber']);
        }
        if($validatedData['description']!=null)
        {
            $retObj=$retObj->orWhere('description','like','%'.$validatedData['description'].'%');
        }
        if($validatedData['transDate']!=null)
        {
            $retObj=$retObj->orWhere('created_at',$validatedData['transDate']);
        }
        if($validatedData['initBy']!=null)
        {
            $retObj=$retObj->orWhere('initBy',$validatedData['initBy']);
        }
        if($validatedData['amount']!=null)
        {
            $retObj=$retObj->orWhere('amount',$validatedData['amount']);
        } if($validatedData['queueID']!=null)
        {
            $retObj=$retObj->orWhere('queueID',$validatedData['queueID']);
        }
        return $retObj->get();
    }
    public function details(int $number)
    {
        return Account::where('number',$number)->firstOrFail()->setVisible(['balance','name']);
    }
    public function doubleEntryTransaction(DoubleEntryTransactionRequest $request)
    {
        $validatedData=$request->validatedAndSanitized();
        if(System::getPropertyValueByName('should_global_double-entry-transactions-queued')==0) {
            $tr = Transaction::directTransferDeQueue(
                $validatedData['debitAccount'],
                $validatedData['creditAccount'],
                $validatedData['amount'],
                $validatedData['narration'],
                User::getCurrentAPIUser()['collegeUID'],
                '852'
            );
            if($tr>0)
                return['result'=>'success','id'=>$tr];
            else
                abort(422,'Transaction Aborted');
        }
        else{
            //todo make queueable
        }
    }
    public function listAllTransactions()
    {
        $user = User::getCurrentAPIUser()['collegeUID'];
        $this->authorize('viewAll',Transaction::class);
        return Transaction::where([
            ['receiver', $user],
            ['visibility', 1],
        ])->orWhere([
            ['sender', $user],
            ['visibility', 1],
//        ])->orWhere([
//            ['initBy',$user],
//            ['visibility',1],
        ])->get();
    }
}
