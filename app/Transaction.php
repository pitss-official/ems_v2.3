<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function PHPSTORM_META\type;

class Transaction extends Model
{
    protected $visible = array('amount', 'created_at', 'receiver', 'sender', 'initBy', 'id', 'description');
    protected $fillable=array('receiver','sender','description','wasQueued','queueID','amount','visibility','initBy','type');

    public static function directTransferDeQueue(int $debitAccountNumber, int $creditAccountNumber, float $amount, $narration, int $initBy, int $type=100)
    {
        if (User::ifNotExist($initBy))
            return ['error' => 'Invalid Transaction Initiator'];
        if ($amount <= 0)
            return ['error' => 'Invalid Amount'];
        if ($debitAccountNumber == $creditAccountNumber)
            return ['error' => 'Invaild Account Number', 'irata' => 568745];
        if (Account::ifNotExist($debitAccountNumber) || Account::ifNotExist($creditAccountNumber))
            return ['error' => 'Invalid Credit or Debit Account Number'];
        return DB::transaction(function () use ($debitAccountNumber, $creditAccountNumber, $amount, $narration, $initBy,$type) {
            /*
             * Step 1 :  Find the balance in debit and credit account
             */
            $creditAccountInitialBalance = DB::table('accounts')->where('number', $creditAccountNumber)->value('balance');
            $debitAccountInitialBalance = DB::table('accounts')->where('number', $debitAccountNumber)->value('balance');
            /*
             * Step 2 : Calculate the amount for debit and credit accounts
             */
            $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
            $debitAccountFinalBalance = $debitAccountInitialBalance - $amount;
            /*
             * Step 3 : Make a transaction against the record
             */
            $txID = Self::create([
                'type'=>$type,
                    'receiver' => $creditAccountNumber,
                    'sender' => $debitAccountNumber,
                    'description' => $narration,
                    'wasQueued' => 0,
                    'queueID' => null,
                    'amount' => $amount,
                    'visibility' => 1,
                    'initBy' => $initBy,])->id;
            /*
             * Step 4 : Update the balances in the account and return the transactionID
             */
            DB::table('accounts')->where('number', '=', $debitAccountNumber)->update(['balance' => $debitAccountFinalBalance]);
            DB::table('accounts')->where('number', '=', $creditAccountNumber)->update(['balance' => $creditAccountFinalBalance]);
            return $txID;
        }, 2);
    }
    public static function nonDBTransactionDeQueueTranfer(int $debitAccountNumber, int $creditAccountNumber,float $amount, $narration,int $initBy, $visibility = 1,$type=100)
    {
        return self::nonDBTransactionDeQueueTransfer($debitAccountNumber, $creditAccountNumber,$amount, $narration,$initBy, $visibility,$type);
    }
    public static function nonDBTransactionDeQueueTransfer(int $debitAccountNumber, int $creditAccountNumber,float $amount, $narration,int $initBy, $visibility = 1,$type=100)
    {
        if (User::ifNotExist($initBy)) return ['error' => 'Invalid Transaction Initiator'];
        if ($amount <= 0) return ['error' => 'Invalid Amount'];
        if ($debitAccountNumber == $creditAccountNumber) return ['error' => 'Invaild Account Number'];
        if (Account::ifNotExist($debitAccountNumber) || Account::ifNotExist($creditAccountNumber)) return ['error' => 'Invalid Credit or Debit Account Number', 'ln-feed' => 8451];
        $creditAccountInitialBalance = DB::table('accounts')->where('number', $creditAccountNumber)->value('balance');
        $debitAccountInitialBalance = DB::table('accounts')->where('number', $debitAccountNumber)->value('balance');
        /*
         * Step 2 : Calculate the amount for debit and credit accounts
         */
        $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
        $debitAccountFinalBalance = $debitAccountInitialBalance - $amount;
        /*
         * Step 3 : Make a transaction against the record
         */
        $txID = self::create(
            [
                'receiver' => $creditAccountNumber,
                'sender' => $debitAccountNumber,
                'description' => $narration,
                'wasQueued' => 0,
                'queueID' => null,
                'amount' => $amount,
                'type'=>$type,
                'visibility' => $visibility,
                'initBy' => $initBy,
            ]
        )->id;
        /*
         * Step 4 : Update the balances in the account and return the transactionID
         */
        DB::table('accounts')->where('number', '=', $debitAccountNumber)->update(['balance' => $debitAccountFinalBalance]);
        DB::table('accounts')->where('number', '=', $creditAccountNumber)->update(['balance' => $creditAccountFinalBalance]);
        return $txID;

    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function debitAccount()
    {
        return $this->belongsTo('App\Account');
    }
    public function creditAccount()
    {
        return $this->belongsTo('App\Account');
    }
    public function cancelTransferRequest($queueID, $remarks, $cancelledBy)
    {
        if (Queue::ifNotExist($queueID))
            return ['error' => 'Queue doesnot exists'];
        if (!User::ifExist($cancelledBy)) return ['error' => 'User does not exist'];
        return DB::transaction(
            function () use ($queueID, $remarks) {
                $queueAccount = 99887766;
                $queue = DB::table('queues')->where('id', $queueID)->first();
                if ($queue->isApproved != 0) return ['error' => 'Already Approved'];
                if ($queue->type != 100) return ['error' => 'Inappropriate Action'];
                /*
                 * Step1: Fetch the amount and credit and debit account from the requested queue
                 */
                $creditAccount = $queue->requestedBy;
                $debitAccount = $queueAccount;
                $amount = floatValue($queue->parameters);
                /*
                 * Step2: Find the balacnces in the debit and credit acounts
                 */
                $debitAccountInitalBalance = DB::table('accounts')->where('number', $queueAccount)->value('balance');
                $creditAccountInitialBalance = DB::table('accounts')->where('collegeUID', $creditAccount)->value('balance');
                $debitAccountFinalBalance = $debitAccountInitalBalance - $amount;
                $creditAccountFinalBalance = $creditAccountInitialBalance + $amount;
                /*
                 * Update the balance in both accounts
                 */
                DB::table('accounts')->where('collegeUID', $creditAccount)->update(['balance' => $creditAccountFinalBalance]);
                DB::table('accounts')->where('number', $queueAccount)->update(['balance' => $debitAccountFinalBalance]);
                /*
                 * Insert a Record in Transactions
                 */
                $txID = self::create(
                    [
                        'receiver' => $creditAccount,
                        'sender' => $queueAccount,
                        'description' => 'Money transfer request declined with Message: ' . $remarks,
                        'wasQueued' => 1,
                        'queueID' => $queueID,
                        'amount' => $amount,
                        'visibility' => 1,
                        'initBy' => $queueAccount,
                    ]
                );
                /*
                * Step 4: Mark the queue as processed
                */
                DB::table('queues')->where('id', $queueID)->update(
                    [
                        'visibility' => 0,
                        'isApproved' => 1,
                        'approvedBy' => 0,
                        'approveTimeRemarks' => $remarks,
                        'approvalTime' => Carbon::now()
                    ]);
                return $txID;
            }
        );
    }
}
