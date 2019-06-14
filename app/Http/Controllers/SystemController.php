<?php

namespace App\Http\Controllers;

use App\Account;
use App\SmartCard;
use App\User;

class SystemController extends Controller
{
    //
    //destry this after production
    public function test($param)
    {
        set_time_limit(0);
        return SmartCard::generateCards(8,500);
    }
}
