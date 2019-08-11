<?php

namespace App\Http\Controllers\API;

use App\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashFlowCreateForStudentRequest;
use App\Http\Requests\TransactionSearchRequest;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function search(TransactionSearchRequest $request)
    {
        $validatedData=$request->validatedAndSanitized();
        $this->authorize('search',Transaction::class);
        return Transaction::where('id',$validatedData['transactionID'])
            ->orWhere('receiver',$validatedData['collegeUID'])
            ->orWhere('sender',$validatedData['collegeUID'])
            ->orWhere('description','like','%'.$validatedData['description'].'%')
            ->orWhere('created_at',$validatedData['transDate'])
            ->orWhere('initBy',$validatedData['initBy'])
            ->orWhere('amount',$validatedData['amount'])
            ->get();
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
