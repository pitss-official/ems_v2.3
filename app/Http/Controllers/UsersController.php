<?php

namespace App\Http\Controllers;

use App\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function getUserName($collegeUID)
    {
        $count = \App\User:: all()->where('collegeUID', '=', $collegeUID)->count();
        if ($count)
            return \App\User:: all()->where('collegeUID', '=', $collegeUID)->first()->setVisible(['firstName', 'lastName', 'middleName']);
    }

    public function getAllCoordinators()
    {
        return User::getAllCoordinators();
    }

    public function setTheme($themeName)
    {
        $styles=['blue','purple','megna','red','green','default','default-dark','green-dark','red-dark','blue-dark','purple-dark','megna-dark',];
        $indice= array_search($themeName,$styles);
        try{
            $user=Auth::guard('api')->user();
            $user->theme=$indice;
            $user->save();
            return ["message"=>"Theme Set"];
        }catch (\Exception $e)
        {
            die("Unauthorized");
        }
        /*
         * 0:blue.css
         * 1:purple.css
         * 2:megna.css
         * 3:red.css
         * 4:green.css
         * 5:default.css
         * 6:default-dark.css
         * 7:green-dark.css
         * 8:red-dark.css
         * 9:blue-dark.css
         * 10:purple-dark.css
         * 11:megna-dark.css
         */
    }
}
