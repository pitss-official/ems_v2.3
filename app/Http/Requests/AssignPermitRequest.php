<?php

namespace App\Http\Requests;

use App\System;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class AssignPermitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return $this->user('api')->can('adminAssignIncentiveAndPermissions',User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'collegeUID'=>'bail|required|numeric|digits:8|exists:users,collegeUID',
            'power'=>'bail|required|numeric|min:0|max:1024',
            'incentiveRate'=>'bail|required|numeric|min:0|max:100',
            'active'=>'bail|required|boolean',
        ];
    }
    public function attributes()
    {
        return [
            'collegeUID'=>'college ID',
            'power'=>'power',
            'incentiveRate'=>'incentive rate',
            'active'=>'login state',
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
