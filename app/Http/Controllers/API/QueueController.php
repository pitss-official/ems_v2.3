<?php

namespace App\Http\Controllers\API;

use App\Exceptions\QueuesExeception;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBalanceTransferRequest;
use App\Http\Requests\QueueApprovalRequest;
use App\Http\Requests\QueueDenyAutoRequest;
use App\Http\Requests\QueueStoreRequest;
use App\Queue;
use App\User;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {   $this->authorize('list',Queue::class);
        $collegeUID = User::getCurrentAPIUser()['collegeUID'];
        $level = User::getCurrentAPIUser()['level'];
        $qs= Queue::where([
            ['specificApproval', '=', $collegeUID],
            ['isApproved', '!=', 1],
            ['approvedBy', 0],
            ['visibility', '!=', 0],
            ['type','!=',505]])
            ->orWhere([
                ['authenticationLevel', '<=', $level],
                ['isApproved', '!=', 1],
                ['approvedBy', 0],
                ['visibility', '!=', 0],
                ['type','!=',505]
            ])->orWhere([
                ['requestedBy', '=', $collegeUID],
                ['isApproved', '!=', 1],
                ['approvedBy', 0],
                ['visibility', '!=', 0],
                ['type','!=',505]
            ])->get();
        return $qs;
    }
    public function store(QueueStoreRequest $request)
    {
        //todo:workkkkk
        $validatedData=$request->validatedAndSanitized();
        $q = new Queue();
        $sender=User::getCurrentAPIUser()['collegeUID'];
        $id=$q->createTransferRequest($sender,$validatedData['collegeUID'],$validatedData['amount'],"$sender has sent ₹".$validatedData['amount']." to you. Message : ".$validatedData['narration'].".");
        if(is_numeric($id))
            return["result"=>"success","id"=>$id];
        else
            return ["result"=>"error"];
    }
    public function storeBalanceTransferRequest(CreateBalanceTransferRequest $request)
    {
        $validatedData=$request->validatedAndSanitized();
        $q = new Queue();
        $sender=User::getCurrentAPIUser()['collegeUID'];
        $id=$q->createReceiveMoneyRequest($sender,$validatedData['collegeUID'],$validatedData['amount'],$validatedData['narration'],"Requested ₹".$validatedData['amount']." from you.");
        if(is_numeric($id))
            return["result"=>"success","id"=>$id];
        else
            abort(422,'Invalid');
    }
    public function getApprovalDetails(QueueApprovalRequest $request){
        $validatedData = $request->validatedAndSanitized();
        $q=Queue::findOrFail($validatedData['id']);
        $approvedBy = User::getCurrentAPIUser()['collegeUID'];
        return ["result"=>'success','id'=>$q->approveAutoType($approvedBy,$validatedData['approvalRemarks'])];
    }
    public function denyRequestDetails(QueueDenyAutoRequest $request){
        $validatedData = $request->validatedAndSanitized();
        $q=Queue::findOrFail($validatedData['id']);
        $deniedBy = User::getCurrentAPIUser()['collegeUID'];
        return ["result"=>'success','id'=>$q->approveAutoType($deniedBy,$validatedData['approvalRemarks'])];
    }
}
