<?php

namespace App\Http\Requests;

use App\Attendance;
use App\System;
use Illuminate\Foundation\Http\FormRequest;

class AttendanceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('mark',Attendance::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'headcount'=>'required|integer|min:0',
            'students.*.collegeUID'=>'required|exists:enrollments,participantCollegeUID|numeric|digits:8',
            'dateid'=>'required|numeric|exists:eventdates,id|min:1',
            'students.*.enrollmentID'=>'required|numeric|exists:enrollments,id',
            'students.*.collegeUID'=>'required|numeric|digits:8|exists:users,collegeUID',
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
    public function attributes()
    {
        return[
            'headcount'=>'Head Count',
            'students.*.collegeUID'=>'College ID',
            'dateid'=>'Selected Date',
            'students.*.enrollmentID'=>'Enrollment Number',
            'students.*.collegeUID'=>'College ID',
        ];
    }
}
