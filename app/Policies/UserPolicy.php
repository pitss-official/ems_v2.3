<?php

namespace App\Policies;

use App\System;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    public function viewBreadcrumb(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_view_self_breadcrumb_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
}
