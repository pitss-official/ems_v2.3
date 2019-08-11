<?php

namespace App\Http\Requests;

use App\System;
use App\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class CashFlowCreateForStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('collectionFromStudent',Transaction::class);
    }
    public function rules()
    {
        return [
            'collegeUID' => 'required|integer|digits:8|exists:users,collegeUID',
            'mobile' => 'nullable|integer|digits:10',
            'amount' => 'required|numeric|min:1'
        ];
    }
    public function attributes()
    {
        return[
            'collegeUID' => 'College ID',
            'mobile' => 'Mobile Number',
            'amount' => 'Amount'
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
