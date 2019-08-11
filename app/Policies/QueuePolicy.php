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
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the queue.
     *
     * @param  \App\User  $user
     * @param  \App\Queue  $queue
     * @return mixed
     */
    public function update(User $user, Queue $queue)
    {
        //
    }

    /**
     * Determine whether the user can delete the queue.
     *
     * @param  \App\User  $user
     * @param  \App\Queue  $queue
     * @return mixed
     */
    public function delete(User $user, Queue $queue)
    {
        //
    }

    /**
     * Determine whether the user can restore the queue.
     *
     * @param  \App\User  $user
     * @param  \App\Queue  $queue
     * @return mixed
     */
    public function restore(User $user, Queue $queue)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the queue.
     *
     * @param  \App\User  $user
     * @param  \App\Queue  $queue
     * @return mixed
     */
    public function forceDelete(User $user, Queue $queue)
    {
        //
    }
}
