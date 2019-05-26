<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Queue;
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
        $collegeUID=Auth::guard('api')->user()->collegeUID;
        $level=Auth::guard('api')->user()->authorityLevel;
        return Queue::where([
            ['specificApproval','=',$collegeUID],
            ['isApproved','!=',1],
            ['approvedBy',0],
            ['visibility','!=',0]])
            ->orWhere([
                ['authenticationLevel','<=',$level],
                ['isApproved','!=',1],
                ['approvedBy',0],
                ['visibility','!=',0]
        ])->orWhere([
            ['requestedBy','=',$collegeUID],
                ['isApproved','!=',1],
                ['approvedBy',0],
                ['visibility','!=',0]
            ])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //æ
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
