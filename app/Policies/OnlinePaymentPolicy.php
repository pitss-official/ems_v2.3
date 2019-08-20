<?php

namespace App\Policies;

use App\System;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OnlinePaymentPolicy
{
    use HandlesAuthorization;

    public function payDues(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_pay_organization_online-pay_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
}
