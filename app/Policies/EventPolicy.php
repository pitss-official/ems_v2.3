<?php

namespace App\Policies;

use App\System;
use App\User;
use App\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;
    public function create(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_create_global_event_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    public function listByDate(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_view_global_events-by-date_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }public function listTeamable(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_view_global_events-teamable_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }public function listAll(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_view_global_events-all_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
}
