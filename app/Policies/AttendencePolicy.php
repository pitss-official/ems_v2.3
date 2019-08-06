<?php

namespace App\Policies;

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
    public function view(User $user, Attendance $attendance)
    {
        //
    }

    /**
     * Determine whether the user can create attendances.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the attendance.
     *
     * @param  \App\User  $user
     * @param  \App\Attendance  $attendance
     * @return mixed
     */
    public function update(User $user, Attendance $attendance)
    {
        //
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
