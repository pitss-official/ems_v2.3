<?php

namespace App\Http\Requests;

use App\System;
use App\Team;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user('api')->can('update',Team::class);
    }
    public function rules()
    {
        return [
            'regNo'=> 'bail|required|integer|digits:8|exists:enrollments,participantCollegeUID',
            'enrollmentID'=> 'bail|required|integer|exists:enrollments,id',
            'newTeamID'=> 'bail|required|min:0|exists:teams,id',
        ];
    }
    public function attributes()
    {
        return [
            'regNo'=> 'College ID',
            'enrollmentID'=> 'Enrollment',
            'newTeamID'=> 'Team',
        ];
    }

    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
