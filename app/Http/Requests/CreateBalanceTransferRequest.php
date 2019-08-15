<?php

namespace App\Http\Requests;

use App\Queue;
use App\System;
use Illuminate\Foundation\Http\FormRequest;

class CreateBalanceTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('createBalanceTransfer',Queue::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'collegeUID'=>'required|numeric|digits:8|exists:users,collegeUID|exists:accounts,number|exists:accounts,collegeUID',
            'amount'=>'required|numeric|between:1,9999999999999999999|min:1',
            'narration'=>'required|string|min:1|max:100',
            'mobile'=>'nullable|numeric|digits:10'
        ];
    }
    public function attributes()
    {
        return [
            'collegeUID'=>'College ID',
            'amount'=>'amount',
            'narration'=>'message',
            'mobile'=>'mobile'
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
