<?php

namespace App\Http\Requests;

use App\System;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('adminCreateNewUser',User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'bail|required|string|min:1|max:25',
            'middleName' => 'nullable|string|min:1|max:25',
            'lastName' => 'nullable|string|min:1|max:25',
            'fathersName' => 'nullable|string|min:1|max:100',
            'gender' => 'bail|required|numeric|digits_between:0,3',
            'birthday' => 'nullable|date',
            'nationality' => 'nullable|string|max:5',
            'bloodGroup' => 'nullable|string|max:5',
            'mobile' => 'bail|required|numeric|digits:10,unique:users,mobile',
            'altMobile' => 'nullable|integer|digits:10|unique:users',
            'address' => 'nullable|string|max:250',
            'collegeUID' => 'unique:users,collegeUID',
            'email' => 'bail|required|email|unique:users,email',
            'branch'=>'bail|required|string|min:3|max:255',
            'school'=>'bail|required|string|min:1|max:2',
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'email',
            'branch'=>'course',
            'school'=>'school',
            'fathersName' => "Father's Name",
            'firstName' => 'First Name',
            'middleName' => 'Middle Name',
            'lastName' => 'Last Name',
            'mobile' => 'Mobile',
            'altMobile' => 'Alt. Mobile',
            'gender' => 'Gender',
            'address' => 'Address',
            'nationality' => 'nationality',
            'bloodGroup' => 'blood group',
            'birthday' => 'birthday',
            'collegeUID' => 'College ID',
        ];
    }

    /**
     * @param array $skippedKeys
     * @return array
     */
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
