<?php

namespace App\Http\Requests;

use App\Attendance;
use App\System;
use Illuminate\Foundation\Http\FormRequest;

class AttendanceRejectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('reject',Attendance::class);
    }
    public function rules()
    {
        return [
            'queueID'=> 'bail|required|integer|min:0|exists:queues,id',
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
