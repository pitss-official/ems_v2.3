<?php

namespace App\Policies;

use App\System;
use App\User;
use App\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;
    public function viewAll(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_view_self_transactions_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    public function search(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_search_non-self_transactions_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    public function collectionFromStudent(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_collect-cash-from-student_self_transactions_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    public function performDoubleEntryTransaction(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_create_global_double-entry-transaction_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }
    /**
     * Determine whether the user can create transactions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the transaction.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function update(User $user, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the user can delete the transaction.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function delete(User $user, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the user can restore the transaction.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function restore(User $user, Transaction $transaction)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the transaction.
     *
     * @param  \App\User  $user
     * @param  \App\Transaction  $transaction
     * @return mixed
     */
    public function forceDelete(User $user, Transaction $transaction)
    {
        //
    }
}
