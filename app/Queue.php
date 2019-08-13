<?php

namespace App;

use App\Exceptions\QueuesExeception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Transaction;

class Queue extends Model
{
    protected $visible = ['requestedBy', 'created_at', 'requesterRemarks', 'id', 'authenticationLevel','typeMessage', 'parameters'];
    protected $fillable=['requestedBy','type','typeMessage','requesterRemarks','parameters','authenticationLevel','specificApproval','visibility'];
    public function initiator()
    {
        return $this->hasOne('App\User');
    }

    public function approver()
    {
        return $this->hasOne('App\User');
    }
    public function createReceiveMoneyRequest(int $requestedBy, int $intendedSender, float $amount, $requesterRemarks, $typeMessage="")
    {
        if ($amount <= 0)
            throw new QueuesExeception('Amount or your account balance can not be negative. Behaviour Instance recorded');
        if ($requestedBy == $intendedSender)
            return ['result'=>"error",'error' => 'Sender and Receiver can not be same'];
        if (User::ifNotExist($intendedSender) || User::ifNotExist($requestedBy))
            return ['result'=>"error",'error' => 'Invaild Sender or Receiver for transaction'];
        if(strip_tags($requesterRemarks)!=$requesterRemarks)
        {
            throw new QueuesExeception('UNISYX Engine: Code injection detected. Behaviour Instance recorded');
        }
        if($typeMessage=="")
            $msg="Money Request";
        else
            $msg=$typeMessage;
        return DB::transaction(
            function ()
            use ($requestedBy, $requesterRemarks, $intendedSender, $amount,$msg) {
                //update the balance of sender [debit]
                //create a queue having specific approver
                //store the id of the queue and return it
                //create a transaction having sender as sender and receiver as 99887766 as account number
                //get the balance of the system
                //update the balance of the system [credit]
                //return the queue id
                /*
                 * Step 0 : Set the Reciplenet to Queues Request account and Initialize the specific approve variable
                 */
                $specificApprover = $intendedSender;
                $queueAccount = System::queueAccount();
                $authenticationLevel = System::sendMoneyLevel();

                /*
                 * Step 0.1: Check the account type of the receiver to make sure the sender is not trying to send into system account
                 */
//                $reciplentAccountType = DB::table('accounts')->where('collegeUID', $reciplentCollegeUID)->value('type');
                if (Account::isSystemAccount($intendedSender) != 0) return ["result"=>"error",'error' => 'You Cannot receive money to this user'];

                /*
                 * Step1 :  Fetch the initial balance of Credit and Debit Account
                 */
                $debitAccountInitialBalance = DB::table('accounts')->where('collegeUID', $intendedSender)->value('balance');
                $creditAccountInitialBalance = DB::table('accounts')->where('number', $queueAccount)->value('balance');
                /*
                 * Step 2 : Find and Update the account balance
                 */
                $debitAccountFinalBalance = $debitAccountInitialBalance - $amount;
                $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
                DB::table('accounts')->where('collegeUID', $intendedSender)->update(['balance' => $debitAccountFinalBalance]);
                DB::table('accounts')->where('number', $queueAccount)->update(['balance' => $creditAccountFinalBalance]);
                /*
                 * Step 3 : Attach a queue to this specific transaction
                 */
                $queueID = DB::table('queues')->insertGetId(
                    [
                        'requesterRemarks' => $requesterRemarks,
                        'requestedBy' => $requestedBy,
                        'authenticationLevel' => $authenticationLevel,
                        'type' => 101,
                        'specificApproval' => $specificApprover,
                        'parameters' => $amount,
                        'typeMessage'=>$msg,
                        'created_at' => Carbon::now(),
                    ]
                );
                /*
                 * Step 4 : Attach a Transaction Associated with this transfer
                 */
                $txID = DB::table('transactions')->insertGetId
                (
                    [
                        'receiver' => $queueAccount,
                        'sender' => $intendedSender,
                        'description' => 'Transfer request scheduled for ' . $requestedBy,
                        'wasQueued' => 1,
                        'queueID' => $queueID,
                        'amount' => $amount,
                        'visibility' => 1,
                        'created_at' => Carbon::now(),
                        'initBy' => $requestedBy,
                    ]
                );
                return $txID;

            }, 5);
    }
    public function approveReceiveMoneyRequest($approverUID, $approvalRemarks)
    {
        $queueID = $this->id;
        if (Queue::ifNotExist($queueID) || User::ifNotExist($approverUID))
            return ['error' => 'Queue ID or Approver ID is Invalid'];
        if (Queue::findOrFail($queueID)->authenticationLevel > User::findAuthenticationLevel($approverUID))
            return ['error' => 'You are not allowed to Approve this transaction'];
        if(strip_tags($approvalRemarks)!=$approvalRemarks)
        {
            throw new QueuesExeception('UNISYX Engine: Code injection detected. Behaviour Instance recorded');
        }
        return DB::transaction(
            function () use ($queueID, $approverUID, $approvalRemarks) {
                $queueAccount = System::queueAccount();
                $userAuthenticationLevel = System::sendMoneyLevel();
                /*
                 * Step 1 : Find the assoc queue with the queue ID
                 */
//                $queue = DB::table('queues')->where('id', $queueID)->first();
                $requesterAccount=$this->requestedBy;
//                $requesterAccount=$queue->requestedBy;
                if ($this->type != 101) return ['error' => 'Inappropriate Action'];
                $params=explode('|',$this->parameters);
                $amount = floatval($params[0]);
                if ($amount <= 0)
                    throw new QueuesExeception('Amount or your account balance can not be negative. Behaviour Instance recorded');
                if(Account::balance($approverUID)<0)throw new QueuesExeception('You have insufficient balance. Add money and try again');
                $associatedApprover = $this->specificApproval;
                if ($approverUID != $associatedApprover) return ['result'=>'error','message' => 'Un Authorized'];
                if ($this->isApproved != 0) return ['error' => 'Already Approved'];
                if ($userAuthenticationLevel < $this->authenticationLevel) return ['result'=>'error','message' => 'You are not Eligible for this action'];
                /*
                 * Step 2 : Initiate a Transfer Request
                 */
                $creditAccountInitialBalance = DB::table('accounts')->where('collegeUID', $requesterAccount)->value('balance');
                $debitAccountInitialBalance = DB::table('accounts')->where('number', $queueAccount)->value('balance');
                $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
                $debitAccountFinalBalance = $debitAccountInitialBalance - $amount;
                /*
                 * Step 2.1 : Update the balances in Both debit and Credit Account
                 */
                DB::table('accounts')->where('collegeUID', $requesterAccount)->update(['balance' => $creditAccountFinalBalance]);
                DB::table('accounts')->where('number', $queueAccount)->update(['balance' => $debitAccountFinalBalance]);
                /*
                 * Step 3 : Insert Into Transactions
                 */
                $txID = \App\Transaction::create
                (
                    [
                        'receiver' => $requesterAccount,
                        'sender' => $queueAccount,
                        'description' => 'Money Transferred from ' . $this->associatedApprover . ' ' . 'using Transfer Request',
                        'wasQueued' => 1,'type'=>$params[1],
                        'queueID' => $queueID,
                        'amount' => $amount,
                        'visibility' => 1,
                        'initBy' => $approverUID
                    ]
                )->id;
                /*
                 * Step 4: Mark the queue as processed
                 */
                DB::table('queues')->where('id', $queueID)->update(
                    [
                        'visibility' => 0,
                        'isApproved' => 1,
                        'approvedBy' => $approverUID,
                        'approveTimeRemarks' => $approvalRemarks,
                        'approvalTime' => Carbon::now()
                    ]);
                return $txID;
            }, 5);
    }
    public function rejectReceiveMoneyRequest($approverUID, $approvalRemarks)
    {
        $queueID = $this->id;
        if (Queue::ifNotExist($queueID) || User::ifNotExist($approverUID))
            return ['error' => 'Queue ID or Approver ID is Invalid'];
//        if (Queue::findOrFail($queueID)->authenticationLevel > User::findAuthenticationLevel($approverUID))
//            return ['error' => 'You are not allowed to reject this transaction'];
        if(strip_tags($approvalRemarks)!=$approvalRemarks)
        {
            throw new QueuesExeception('UNISYX Engine: Code injection detected. Behaviour Instance recorded');
        }
        return DB::transaction(
            function () use ($queueID, $approverUID, $approvalRemarks) {
                $queueAccount = System::queueAccount();
                $userAuthenticationLevel = System::sendMoneyLevel();
                /*
                 * Step 1 : Find the assoc queue with the queue ID
                 */
                $queue = Queue::firstOrFail($queueID);
                if ($queue->type != 101) return ['error' => 'Inappropriate Action'];
                $amount = floatval($queue->parameters);
                if ($amount <= 0)
                    throw new QueuesExeception('Amount or your account balance can not be negative. Behaviour Instance recorded');
                $associatedApprover = $queue->specificApproval;
                if ($approverUID != $associatedApprover) return ['error' => 'Un Authorized'];
                if ($queue->isApproved != 0) return ['error' => 'Already Approved'];
                if ($userAuthenticationLevel < $queue->authenticationLevel) return ['error' => 'You are not Eligible for this action'];
                /*
                 * Step 2 : Initiate a Transfer Request
                 */
                $creditAccountInitialBalance = DB::table('accounts')->where('collegeUID', $approverUID)->value('balance');
                $debitAccountInitialBalance = DB::table('accounts')->where('number', $queueAccount)->value('balance');
                $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
                $debitAccountFinalBalance = $debitAccountInitialBalance - $amount;
                /*
                 * Step 2.1 : Update the balances in Both debit and Credit Account
                 */
                DB::table('accounts')->where('collegeUID', $approverUID)->update(['balance' => $creditAccountFinalBalance]);
                DB::table('accounts')->where('number', $queueAccount)->update(['balance' => $debitAccountFinalBalance]);
                /*
                 * Step 3 : Insert Into Transactions
                 */
                $txID = DB::table('transactions')->insert
                (
                    [
                        'receiver' => $approverUID,
                        'sender' => $queueAccount,
                        'description' => 'Money rollback for balance request from ' . $queue->requestedBy . ' ' . 'using Transfer Request',
                        'wasQueued' => 1,
                        'queueID' => $queueID,
                        'amount' => $amount,
                        'visibility' => 1,
                        'created_at' => Carbon::now(),
                        'initBy' => $approverUID
                    ]
                );
                /*
                 * Step 4: Mark the queue as processed
                 */
                DB::table('queues')->where('id', $queueID)->update(
                    [
                        'visibility' => 0,
                        'isApproved' => 1,
                        'approvedBy' => $approverUID,
                        'approveTimeRemarks' => $approvalRemarks,
                        'approvalTime' => Carbon::now()
                    ]);
                return $txID;
            }, 5);
    }
    public function createTransferRequest(int $senderCollegeUID,int $reciplentCollegeUID,float $amount, $senderRemarks,$typeMessage="")
    {
        if ($senderCollegeUID == $reciplentCollegeUID)
            return ['result'=>"error",'error' => 'Sender and Receiver can not be same'];
        if (User::ifNotExist($senderCollegeUID) || User::ifNotExist($reciplentCollegeUID))
            return ['result'=>"error",'error' => 'Invaild Sender or Receiver for transaction'];
        if ($amount <= 0||Account::balance($senderCollegeUID)<=$amount)
            throw new QueuesExeception('Amount or your account balance can not be negative. Behaviour Instance recorded');
//            return ['result'=>"error",'error' => 'Amount can not be negative. Behaviour Instance recorded'];
        if(strip_tags($senderRemarks)!=$senderRemarks)
        {
            throw new QueuesExeception('UNISYX Engine: Code injection detected. Behaviour Instance recorded');
        }
        if($typeMessage=="")
            $msg="Money Transfer";
        else
            $msg=$typeMessage;
        return DB::transaction(
            function ()
            use ($senderCollegeUID, $senderRemarks, $reciplentCollegeUID, $amount,$msg) {
                //update the balance of sender [debit]
                //create a queue having specific approver
                //store the id of the queue and return it
                //create a transaction having sender as sender and receiver as 99887766 as account number
                //get the balance of the system
                //update the balance of the system [credit]
                //return the queue id
                /*
                 * Step 0 : Set the Reciplenet to Queues Request account and Initialize the specific approve variable
                 */
                $specificApprover = $reciplentCollegeUID;
                $queueAccount = System::queueAccount();
                $authenticationLevel = 0;

                /*
                 * Step 0.1: Check the account type of the receiver to make sure the sender is not trying to send into system account
                 */
//                $reciplentAccountType = DB::table('accounts')->where('collegeUID', $reciplentCollegeUID)->value('type');
                if (Account::isSystemAccount($reciplentCollegeUID) != 0) return ["result"=>"error",'error' => 'You Cannot send money to this user'];

                /*
                 * Step1 :  Fetch the initial balance of Credit and Debit Account
                 */
                $debitAccountInitialBalance = DB::table('accounts')->where('collegeUID', $senderCollegeUID)->value('balance');
                $creditAccountInitialBalance = DB::table('accounts')->where('number', $queueAccount)->value('balance');
                /*
                 * Step 2 : Find and Update the account balance
                 */
                $debitAccountFinalBalance = $debitAccountInitialBalance - $amount;
                $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
                DB::table('accounts')->where('collegeUID', $senderCollegeUID)->update(['balance' => $debitAccountFinalBalance]);
                DB::table('accounts')->where('number', $queueAccount)->update(['balance' => $creditAccountFinalBalance]);
                /*
                 * Step 3 : Attach a queue to this specific transaction
                 */
                $queueID = DB::table('queues')->insertGetId(
                    [
                        'requesterRemarks' => $senderRemarks,
                        'requestedBy' => $senderCollegeUID,
                        'authenticationLevel' => $authenticationLevel,
                        'type' => 100,
                        'specificApproval' => $specificApprover,
                        'parameters' => $amount,
                        'typeMessage'=>$msg,
                        'created_at' => Carbon::now(),
                    ]
                );
                /*
                 * Step 4 : Attach a Transaction Associated with this transfer
                 */
                $txID = DB::table('transactions')->insertGetId
                (
                    [
                        'receiver' => $queueAccount,
                        'sender' => $senderCollegeUID,
                        'description' => 'Money requested by' . $reciplentCollegeUID.' via request',
                        'wasQueued' => 1,
                        'queueID' => $queueID,
                        'amount' => $amount,
                        'visibility' => 0,
                        'created_at' => Carbon::now(),
                        'initBy' => $senderCollegeUID,
                    ]
                );
                return $txID;

            }, 5);
    }
    public function approveTransferRequest($approverUID, $approvalRemarks)
    {

        //todo:remove bug
        $queueID = $this->id;
        if (Queue::ifNotExist($queueID) || User::ifNotExist($approverUID))
            return ['error' => 'Queue ID or Approver ID is Invalid'];
        if (Queue::where('id', $queueID)->value('authenticationLevel') > User::findAuthenticationLevel($approverUID))
            return ['error' => 'You are not allowed to Approve this transaction'];

        return DB::transaction(
            function () use ($queueID, $approverUID, $approvalRemarks) {
                $queueAccount = 99887766;
                $userAuthenticationLevel = 0;
                /*
                 * Step 1 : Find the assoc queue with the queue ID
                 */
                $queue = DB::table('queues')->where('id', $queueID)->first();
                if ($queue->type != 100) return ['error' => 'Inappropriate Action'];
                $amount = floatval($queue->parameters);
                $associatedApprover = $queue->specificApproval;
                if ($approverUID != $associatedApprover) return ['error' => 'Un Authorized'];
                if ($queue->isApproved != 0) return ['error' => 'Already Approved'];
                if ($userAuthenticationLevel < $queue->authenticationLevel) return ['error' => 'You are not Eligible for this action'];
                /*
                 * Step 2 : Initiate a Transfer Request
                 */
                $creditAccountInitialBalance = DB::table('accounts')->where('collegeUID', $approverUID)->value('balance');
                $debitAccountInitialBalance = DB::table('accounts')->where('number', $queueAccount)->value('balance');
                $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
                $debitAccountFinalBalance = $debitAccountInitialBalance - $amount;
                /*
                 * Step 2.1 : Update the balances in Both debit and Credit Account
                 */
                DB::table('accounts')->where('collegeUID', $approverUID)->update(['balance' => $creditAccountFinalBalance]);
                DB::table('accounts')->where('number', $queueAccount)->update(['balance' => $debitAccountFinalBalance]);
                /*
                 * Step 3 : Insert Into Transactions
                 */
                $txID = DB::table('transactions')->insert
                (
                    [
                        'receiver' => $approverUID,
                        'sender' => $queueAccount,
                        'description' => 'Money Transferred from ' . $queue->requestedBy . ' ' . 'using Transfer Request',
                        'wasQueued' => 1,
                        'queueID' => $queueID,
                        'amount' => $amount,
                        'visibility' => 1,
                        'created_at' => Carbon::now(),
                        'initBy' => $approverUID
                    ]
                );
                /*
                 * Step 4: Mark the queue as processed
                 */
                DB::table('queues')->where('id', $queueID)->update(
                    [
                        'visibility' => 0,
                        'isApproved' => 1,
                        'approvedBy' => $approverUID,
                        'approveTimeRemarks' => $approvalRemarks,
                        'approvalTime' => Carbon::now()
                    ]);
                return $txID;
            }, 5);
    }

    public static function ifNotExist($id)
    {
        if (Queue::where('id', $id)->count() != 1)
            return true;
        else return false;
    }

    public function eventExpenseReimburseRequest($requestedByCollegeUID, $amount, $narration, $eventID)
    {
        $eventExpensesAccount = '999' . $eventID . '08';
        $requestLevel = 100;
        if (Event::isNotExist($eventID)) return ['title' => 'Event Not Found', 'error' => 'Event with Event ID ' . $eventID . 'not found. Kindly Contact System Administrator'];
        if (User::ifNotExist($requestedByCollegeUID)) return ['title' => 'Internal Server Error', 'Transaction has been rolledback due to some internal server error'];
        return $this->createGlobalTransferRequest($requestedByCollegeUID, $requestLevel, $amount, $eventExpensesAccount, 'Event Expense for event:' . $eventID . ' Msg:' . $narration);
    }
    public function createGlobalTransferRequest(int $requestedBy, int $transactionLevel, float $amount, int $debitAccount, $narration,int $targetTransactionType=100, int $creditAccount = 0)
    {
        //remove bug
        if ($amount <= 0) return ['title' => 'Invalid Amount', 'error' => 'Invalid Amount Entered'];
        if (User::ifNotExist($requestedBy) || Account::ifNotExist($debitAccount)) return ['title' => 'Internal Server Error', 'Transaction has been rolledback due to some internal server error'];
        else {
            return DB::transaction(
                function ()
                use ($requestedBy, $transactionLevel, $amount, $debitAccount, $narration, $creditAccount,$targetTransactionType) {
                    //update the balance of requester [debit]
                    //create a queue having specific approver
                    //store the id of the queue and return it
                    //create a transaction having sender as sender and receiver as 99887766 as account number
                    //get the balance of the system
                    //update the balance of the system [credit]
                    //return the queue id
                    /*
                     * Step 0 : Set the Reciplenet to Queues Request account and Initialize the specific approve variable
                     */
                    $specificApprover = null;
                    $queueAccount = 99887766;
                    $authenticationLevel = $transactionLevel;
                    $senderCollegeUID = $debitAccount;
                    $reciplentCollegeUID = ($creditAccount == 0) ? $requestedBy : $creditAccount;
                    /*
                     * Step 0.1: Check the account type of the receiver to make sure the sender is not trying to send into system account
                     */
                    $reciplentAccountType = DB::table('accounts')->where('collegeUID', $reciplentCollegeUID)->value('type');
                    if ($reciplentAccountType != 0) return ['error' => 'Invalid Receiver Account'];
                    /*
                     * Step1 :  Fetch the initial balance of Credit and Debit Account
                     */
                    $debitAccountInitialBalance = DB::table('accounts')->where('collegeUID', $senderCollegeUID)->value('balance');
                    $creditAccountInitialBalance = DB::table('accounts')->where('number', $queueAccount)->value('balance');
                    /*
                     * Step 2 : Find and Update the account balance
                     */
                    $debitAccountFinalBalance = $debitAccountInitialBalance - $amount;
                    $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
                    DB::table('accounts')->where('collegeUID', $senderCollegeUID)->update(['balance' => $debitAccountFinalBalance]);
                    DB::table('accounts')->where('number', $queueAccount)->update(['balance' => $creditAccountFinalBalance]);
                    /*
                     * Step 3 : Attach a queue to this specific transaction
                     */
                    $queueID = DB::table('queues')->insertGetId(
                        [
                            'requesterRemarks' => $narration,
                            'requestedBy' => $senderCollegeUID,
                            'authenticationLevel' => $authenticationLevel,
                            'type' => 110,
                            'specificApproval' => $specificApprover,
                            'parameters' => $amount.'|transType='.$targetTransactionType,
                            'created_at' => Carbon::now(),
                        ]
                    );
                    /*
                     * Step 4 : Attach a Transaction Associated with this transfer
                     */
                    $txID = DB::table('transactions')->insertGetId
                    (
                        [
                            'receiver' => $queueAccount,
                            'sender' => $senderCollegeUID,
                            'description' => 'Transfer request scheduled for ' . $reciplentCollegeUID,
                            'wasQueued' => 1,
                            'queueID' => $queueID,
                            'amount' => $amount,
                            'visibility' => 0,
                            'created_at' => Carbon::now(),
                            'initBy' => $senderCollegeUID,
                        ]
                    );
                    return $txID;

                }, 5);
        }

    }
    public function approveGlobalTransferRequest($approverUID, $approvalRemarks)
    {
        $queueID = $this->id;
        if (Queue::ifNotExist($queueID) || User::ifNotExist($approverUID))
            return ['error' => 'Queue ID or Approver ID is Invalid'];
        if ($this->authenticationLevel > User::findAuthenticationLevel($approverUID))
            return ['error' => 'You are not allowed to Approve this transaction'];

        return DB::transaction(
            function () use ($queueID, $approverUID, $approvalRemarks) {
                $queueAccount = 99887766;
                $userAuthenticationLevel = 0;
                /*
                 * Step 1 : Find the assoc queue with the queue ID
                 */
                $queue = DB::table('queues')->where('id', $queueID)->first();
                if ($queue->type != 100) return ['error' => 'Inappropriate Action'];
                $amount = floatval($queue->parameters);
                $associatedApprover = $queue->specificApproval;
                if ($approverUID != $associatedApprover) return ['error' => 'Un Authorized'];
                if ($queue->isApproved != 0) return ['error' => 'Already Approved'];
                if ($userAuthenticationLevel < $queue->authenticationLevel) return ['error' => 'You are not Eligible for this action'];
                /*
                 * Step 2 : Initiate a Transfer Request
                 */
                $creditAccountInitialBalance = DB::table('accounts')->where('collegeUID', $approverUID)->value('balance');
                $debitAccountInitialBalance = DB::table('accounts')->where('number', $queueAccount)->value('balance');
                $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
                $debitAccountFinalBalance = $debitAccountInitialBalance - $amount;
                /*
                 * Step 2.1 : Update the balances in Both debit and Credit Account
                 */
                DB::table('accounts')->where('collegeUID', $approverUID)->update(['balance' => $creditAccountFinalBalance]);
                DB::table('accounts')->where('number', $queueAccount)->update(['balance' => $debitAccountFinalBalance]);
                /*
                 * Step 3 : Insert Into Transactions
                 */
                $txID = DB::table('transactions')->insert
                (
                    [
                        'receiver' => $approverUID,
                        'sender' => $queueAccount,
                        'description' => 'Money Transferred from ' . $queue->requestedBy . ' ' . 'using Transfer Request',
                        'wasQueued' => 1,
                        'queueID' => $queueID,
                        'amount' => $amount,
                        'visibility' => 1,
                        'created_at' => Carbon::now(),
                        'initBy' => $approverUID
                    ]
                );
                /*
                 * Step 4: Mark the queue as processed
                 */
                DB::table('queues')->where('id', $queueID)->update(
                    [
                        'visibility' => 0,
                        'isApproved' => 1,
                        'approvedBy' => $approverUID,
                        'approveTimeRemarks' => $approvalRemarks,
                        'approvalTime' => Carbon::now()
                    ]);
                return $txID;
            }, 5);
    }
    public function createAttendanceRequestDeTrans(int $creatorUID,int $eventID, $requesterRemarks,$typeMessage)
    {
        $approverLevel=System::approveAttendanceLevel();
        //step 1: create a queue request with no specific approval
        return Queue::create([
            'requesterRemarks'=>$requesterRemarks,
            'parameters'=>$eventID,
            'requestedBy'=>$creatorUID,
            'authenticationLevel'=>$approverLevel,
            'type'=>505,
            'specificApproval'=>0,
            'visibility'=>1,
            'typeMessage'=>$typeMessage,
        ])->id;
    }
    public function approveAutoType($approverUID, $approvalRemarks){
            if($this->type == 100 ){
                return $this->approveTransferRequest($approverUID, $approvalRemarks);
            }

            else if($this->type == 101 ){
                return $this->approveReceiveMoneyRequest($approverUID, $approvalRemarks);

            }

            else if($this->type == 102 ){ //todo: by anu change queue type
                return $this->approveGlobalTransferRequest($approverUID, $approvalRemarks);

            }
    }

//todo: by anu write all functions
    public function denyAutoType($approverUID, $approvalRemarks){
//        if($this->type == 100 ){
//            return $this->approveTransferRequest($approverUID, $approvalRemarks);
//        }

        if($this->type == 101 ){
            return $this->rejectReceiveMoneyRequest($approverUID, $approvalRemarks);

        }

//        else if($this->type == 102 ){ //todo: by anu change queue type
//            return $this->approveGlobalTransferRequest($approverUID, $approvalRemarks);
//
//        }
    }
}
