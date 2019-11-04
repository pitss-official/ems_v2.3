<?php

namespace App\Http\Requests;

use App\System;
use App\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class DoubleEntryTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('performDoubleEntryTransaction',Transaction::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                    'debitAccount'=> 'required|numeric|exists:accounts,number',
                    'creditAccount'=> 'required|numeric|exists:accounts,number',
                    'narration'=>'required|string|min:3|max:4096',
                    'amount'=>'required|numeric|min:1|max:1000000000',
        ];
    }
    public function attributes()
    {
        return [
            'debitAccount'=> 'Debit Account Number',
            'creditAccount'=> 'Credit Account Number',
            'narration'=>'Transaction Narration',
            'amount'=>'Amount',
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
