<?php

namespace App\Policies;

use App\System;
use App\User;
use App\Team;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;
    public function create(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_create_coordinator-to-participant_team_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    public function update(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_update_coordinator-to-participant_team_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    public function listAssociatedWithUser(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_view_coordinator-to-participant-all-participated-for-user_team_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
}
