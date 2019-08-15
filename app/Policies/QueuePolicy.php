<?php

namespace App\Policies;

use App\System;
use App\User;
use App\Queue;
use Illuminate\Auth\Access\HandlesAuthorization;

class QueuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the queue.
     *
     * @param  \App\User  $user
     * @param  \App\Queue  $queue
     * @return mixed
     */
    public function list(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_view_self_queue_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }

    /**
     * Determine whether the user can create queues.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function createBalanceTransfer(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_create_self_create-balance-transfer_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function approve(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_action_self_approve-queue_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    public function denyAuto(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_action_self_deny-queue_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
}
