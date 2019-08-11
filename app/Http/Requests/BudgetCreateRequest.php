<?php

namespace App\Http\Requests;

use App\Budget;
use App\System;
use Illuminate\Foundation\Http\FormRequest;

class BudgetCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('create',Budget::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'eventID'=>'bail|required|numeric|min:0|exists:events,id',
            'budgetName'=>'bail|required|string|min:0|max:100',
            'value'=>'bail|required|numeric|min:0|max:10000000',
            'isPercentage'=>'nullable|boolean',
            'account'=>'required|numeric|min:0|exists:accounts,number'
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
    public function attributes()
    {
        return [
            'eventID'=>'Event',
            'budgetName'=>'Budget Name',
            'value'=>'Budget Value',
            'isPercentage'=>'Is Value in Percentage',
            'account'=>'Associated Account'
        ];
    }
}
