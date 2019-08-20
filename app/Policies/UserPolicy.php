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
    public function adminCreateNewUser(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_create_global_users_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    public function adminAssignIncentiveAndPermissions(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_critical_global_users-assign-permissions_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
}
