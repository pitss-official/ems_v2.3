<?php

namespace App\Policies;

use App\System;
use App\User;
use App\SmartCard;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmartCardPolicy
{
    use HandlesAuthorization;
    public function create(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_global_non-self_create-smartcards_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
}
