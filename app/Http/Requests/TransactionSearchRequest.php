<?php

namespace App\Http\Requests;

use App\System;
use App\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class TransactionSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('search',Transaction::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transactionID'=>'bail|nullable|exists:transactions,id|numeric|min:0',
            'collegeUID'=>'bail|nullable|exists:users,collegeUID|numeric|digits:8',
            'accountNumber'=>'bail|nullable|exists:accounts,number|numeric',
            'amount'=>'bail|nullable|numeric',
            'queueID'=>'bail|nullable|exists:queues,id|numeric',
            'transDate'=>'bail|nullable|date',
            'description'=>'bail|nullable|string',
            'initBy'=>'bail|nullable|exists:users,collegeUID|numeric|digits:8',
            'name'=>'bail|nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'transactionID'=>'Transaction ID',
            'collegeUID'=>'College ID',
            'accountNumber'=>'Account Number',
            'amount'=>'Amount',
            'queueID'=>'Queue ID',
            'transDate'=>'Transaction Date',
            'description'=>'Description',
            'initBy'=>'Initiated By',
            'name'=>'Name',
        ];
    }

    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
