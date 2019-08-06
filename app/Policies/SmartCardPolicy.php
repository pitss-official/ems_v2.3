<?php

namespace App\Policies;

use App\User;
use App\SmartCard;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmartCardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the smart card.
     *
     * @param  \App\User  $user
     * @param  \App\SmartCard  $smartCard
     * @return mixed
     */
    public function view(User $user, SmartCard $smartCard)
    {
        //
    }

    /**
     * Determine whether the user can create smart cards.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the smart card.
     *
     * @param  \App\User  $user
     * @param  \App\SmartCard  $smartCard
     * @return mixed
     */
    public function update(User $user, SmartCard $smartCard)
    {
        //
    }

    /**
     * Determine whether the user can delete the smart card.
     *
     * @param  \App\User  $user
     * @param  \App\SmartCard  $smartCard
     * @return mixed
     */
    public function delete(User $user, SmartCard $smartCard)
    {
        //
    }

    /**
     * Determine whether the user can restore the smart card.
     *
     * @param  \App\User  $user
     * @param  \App\SmartCard  $smartCard
     * @return mixed
     */
    public function restore(User $user, SmartCard $smartCard)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the smart card.
     *
     * @param  \App\User  $user
     * @param  \App\SmartCard  $smartCard
     * @return mixed
     */
    public function forceDelete(User $user, SmartCard $smartCard)
    {
        //
    }
}
