<?php

namespace App\Http\Controllers\API;

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
        $collegeUID = Auth::guard('api')->user()->collegeUID;
        $level = Auth::guard('api')->user()->authorityLevel;
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
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //todo:workkkkk
        $validatedData=$request->validate([
            'collegeUID'=>'required|numeric|digits:8|exists:users,collegeUID|exists:accounts,number|exists:accounts,collegeUID',
            'amount'=>'required|between:1,9999999999999999999',
            'narration'=>'required|string|min:1|max:100',
            'mobile'=>'nullable|numeric|digits:10'
        ]);
        $q = new Queue();
        $sender=User::getCurrentAPIUser()['collegeUID'];
        $id=$q->createTransferRequest($sender,$validatedData['collegeUID'],$validatedData['amount'],"Money Transfer request to you. Message from sender : ".$validatedData['narration'].".");
        if(is_numeric($id))
            return["result"=>"success","id"=>$id];
        else
            return ["result"=>"error"];
    }
    public function storeBalanceTransferRequest(Request $request)
    {
        $validatedData=$request->validate([
            'collegeUID'=>'required|numeric|digits:8|exists:users,collegeUID|exists:accounts,number|exists:accounts,collegeUID',
            'amount'=>'required|between:1,9999999999999999999',
            'narration'=>'required|string|min:1|max:100',
            'mobile'=>'nullable|numeric|digits:10'
        ]);
        $q = new Queue();
        $sender=User::getCurrentAPIUser()['collegeUID'];
        $id=$q->createRecieveMoneyRequest($sender,$validatedData['collegeUID'],$validatedData['amount'],"Money Transfer request to you. Message from sender : ".$validatedData['narration'].".");
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
