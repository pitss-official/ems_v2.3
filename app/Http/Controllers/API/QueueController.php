<?php

namespace App\Http\Controllers\API;

use App\Exceptions\QueuesExeception;
use App\Http\Controllers\Controller;
use App\Queue;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        //
//        if(\User::ifNotExist(Auth::guard('api')->user()->collegeUID))
//            return ['error'=>'UnAuthenticated','message'=>'User is not eligible for such view'];
        $collegeUID = User::getCurrentAPIUser()['collegeUID'];
        $level = User::getCurrentAPIUser()['level'];
        return Queue::where([
            ['specificApproval', '=', $collegeUID],
            ['isApproved', '!=', 1],
            ['approvedBy', 0],
            ['visibility', '!=', 0]])
            ->orWhere([
                ['authenticationLevel', '<=', $level],
                ['isApproved', '!=', 1],
                ['approvedBy', 0],
                ['visibility', '!=', 0]
            ])->orWhere([
                ['requestedBy', '=', $collegeUID],
                ['isApproved', '!=', 1],
                ['approvedBy', 0],
                ['visibility', '!=', 0]
            ])->get();
    }

    /**
     * Store a newly created resource in storage.
     * @throws QueuesExeception
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //todo:workkkkk
        $validatedData=$request->validate([
            'collegeUID'=>'required|numeric|digits:8|exists:users,collegeUID|exists:accounts,number|exists:accounts,collegeUID',
            'amount'=>'required|numeric|min:1|between:1,9999999',
            'narration'=>'required|string|min:1|max:100',
            'mobile'=>'nullable|numeric|digits:10'
        ]);
        $q = new Queue();
        $sender=User::getCurrentAPIUser()['collegeUID'];
        $id=$q->createTransferRequest($sender,$validatedData['collegeUID'],$validatedData['amount'],"$sender has sent money to you. Message : ".$validatedData['narration'].".");
        if(is_numeric($id))
            return["result"=>"success","id"=>$id];
        else
            return ["result"=>"error"];
    }
    public function storeBalanceTransferRequest(Request $request)
    {
        $validatedData=$request->validate([
            'collegeUID'=>'required|numeric|digits:8|exists:users,collegeUID|exists:accounts,number|exists:accounts,collegeUID',
            'amount'=>'required|numeric|between:1,9999999999999999999|min:1',
            'narration'=>'required|string|min:1|max:100',
            'mobile'=>'nullable|numeric|digits:10'
        ]);
        $q = new Queue();
        $sender=User::getCurrentAPIUser()['collegeUID'];
        $id=$q->createRecieveMoneyRequest($sender,$validatedData['collegeUID'],$validatedData['amount'],"$sender has requested money from you. Message : ".$validatedData['narration'].".");
        if(is_numeric($id))
            return["result"=>"success","id"=>$id];
        else
            return ["result"=>"error"];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function getApprovalDetails(Request $request){
//        $validatedData = $request->validate([
//            'id'=>'',
//            'approveTimeRemarks'=>'',
//        ]);
            return dd($request);
    }




    public function show($id)
    {
        //
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
        //æ
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
}
