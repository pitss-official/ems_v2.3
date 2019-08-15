<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VenuePolicy
{
    use HandlesAuthorization;
    public function create(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_create_self_venue_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    public function verify(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_verify_self_venue_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
}
