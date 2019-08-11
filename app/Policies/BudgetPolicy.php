<?php

namespace App\Policies;

use App\System;
use App\User;
use App\Budget;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudgetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the budget.
     *
     * @param  \App\User  $user
     * @param  \App\Budget  $budget
     * @return mixed
     */
    public function view(User $user, Budget $budget)
    {
        //
    }

    /**
     * Determine whether the user can create budgets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_create_self_event-budget_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }

    /**
     * Determine whether the user can update the budget.
     *
     * @param  \App\User  $user
     * @param  \App\Budget  $budget
     * @return mixed
     */
    public function update(User $user, Budget $budget)
    {
        //
    }

    /**
     * Determine whether the user can delete the budget.
     *
     * @param  \App\User  $user
     * @param  \App\Budget  $budget
     * @return mixed
     */
    public function delete(User $user, Budget $budget)
    {
        //
    }

    /**
     * Determine whether the user can restore the budget.
     *
     * @param  \App\User  $user
     * @param  \App\Budget  $budget
     * @return mixed
     */
    public function restore(User $user, Budget $budget)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the budget.
     *
     * @param  \App\User  $user
     * @param  \App\Budget  $budget
     * @return mixed
     */
    public function forceDelete(User $user, Budget $budget)
    {
        //
    }
}
