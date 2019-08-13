<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Navigator;
use App\User;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function pushAllLinks()
    {
        $currentUser= User::getCurrentAPIUser();
        $navigator=new Navigator();
        return $navigator->getNavigationLinks($currentUser['authorityLevel']);

    }
}
