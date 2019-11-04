<?php

namespace App\Http\Controllers\API;

use App\Dashboard;
use App\Http\Controllers\Controller;
use App\User;

class DashboardController extends Controller
{
    protected $user;
    protected $dashboard;
    public function __construct()
    {
        $this->middleware('auth:api');

    }

    public function breadcumbBalances()
    {
        $this->user=User::getCurrentAPIUser();
        $user=User::where('collegeUID',$this->user['collegeUID'])->first();
        $user->lastLogin=now();
        $user->save();
        $this->dashboard=new Dashboard();
        $this->dashboard->user=$this->user;
        return $this->dashboard->breadcumbData();
    }
    public function test()
    {

    }
}
