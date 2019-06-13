<?php

namespace App\Http\Controllers\API;

use App\Account;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashFlowController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* this function is intentended for transferring money from Coordinator to Enrolling Student
         * Step 1 : Check the limit of the user;
         * Step 2 : Check if the recipient is allowed for direct transfer
         * Step 3 : Perform nonQueue Transfer
         */
        $coordinatorID = User::getCurrentAPIUser()['collegeUID'];
        $validatedData = $request->validate([
            'collegeUID' => 'required|integer|digits:8|exists:users,collegeUID',
            'mobile' => 'nullable|integer|digits:10',
            'amount' => 'required|numeric|min:1'
        ]);
        if ($this->negativeStudentAccountBalance($validatedData['collegeUID'])['balance'] >= 0) {
            throw new \Exception("The recipient has non-negative balance or is inaccessible for you. <br><hr><b>Transaction Truncated</b>");
            return;
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
        //-
        $user = \App\User::findOrFail($id);
        if ($user->authorityLevel <= 10) {
            return $user;
        }
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

    public function listAllTransactions()
    {
        $user = Auth::guard('api')->user()->collegeUID;
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
