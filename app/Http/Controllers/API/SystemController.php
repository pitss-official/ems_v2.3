<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignPermitRequest;
use App\Http\Requests\CreateNewUserRequest;
use App\System;
use App\User;

class SystemController extends Controller
{
    /**
     * SystemController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param CreateNewUserRequest $request
     * @return mixed
     */
    public function createUser(CreateNewUserRequest $request)
    {
        $validatedData=$request->validatedAndSanitized();
        $attrs=array(
            'createdBy'=>User::getCurrentAPIUser()['collegeUID'],
            'status'=>0,
            'referenceUID'=>User::getCurrentAPIUser()['collegeUID'],
            'password'=>\Illuminate\Support\Facades\Hash::make(System::randAlphaNum(20))
        );
        $validatedData=array_merge($validatedData,$attrs);
        return ["result"=>'success','id'=>User::create($validatedData)->id];
    }

    public function assignPermit(AssignPermitRequest $request){
        $validatedData=$request->validatedAndSanitized();
        if($validatedData['collegeUID']==User::getCurrentAPIUser()['collegeUID'])abort(422,'Cannot Instantiate Request');
        if(User::getCurrentAPIUser()['level']<System::getPropertyValueByName('rights_critical_global_users-assign-permissions_level'))abort(422,'Actionable Attempt to theat system');
        if(System::getPropertyValueByName('actions_if_permission_assignment_require_queue')==0)
        {
            $user=User::where('collegeUID',$validatedData['collegeUID'])->first();
            $user->authorityLevel=$validatedData['power'];
            $user->status=$validatedData['active'];
            $user->incentiveRate=$validatedData['incentiveRate'];
            $user->save();
            $user->openAccount();
            return ['result'=>'success','id'=>$user->id];
        }
        else
        {
            //todo make it queueable
        }
    }
}
