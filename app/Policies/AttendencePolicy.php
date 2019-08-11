<?php

namespace App\Policies;

use App\System;
use App\User;
use App\Attendance;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the attendance.
     *
     * @param  \App\User  $user
     * @param  \App\Attendance  $attendance
     * @return mixed
     */
    public function verify(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_authorize_global_attendance-marking_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }

    /**
     * Determine whether the user can create attendances.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function mark(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_create_global_attendance-marking_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }

    /**
     * Determine whether the user can update the attendance.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function reject(User $user)
    {
        $requiredLevel=(int)System::getPropertyValueByName('rights_deny_global_attendance-marking_level');
        if($requiredLevel<=$user->authorityLevel)return true;
        else return false;
    }

    /**
     * Determine whether the user can delete the attendance.
     *
     * @param  \App\User  $user
     * @param  \App\Attendance  $attendance
     * @return mixed
     */
    public function delete(User $user, Attendance $attendance)
    {
        //
    }

    /**
     * Determine whether the user can restore the attendance.
     *
     * @param  \App\User  $user
     * @param  \App\Attendance  $attendance
     * @return mixed
     */
    public function restore(User $user, Attendance $attendance)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the attendance.
     *
     * @param  \App\User  $user
     * @param  \App\Attendance  $attendance
     * @return mixed
     */
    public function forceDelete(User $user, Attendance $attendance)
    {
        //
    }
}
