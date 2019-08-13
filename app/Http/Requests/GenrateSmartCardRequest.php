<?php

namespace App\Http\Requests;

use App\System;
use Illuminate\Foundation\Http\FormRequest;

class GenrateSmartCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'numberPasses'=>'bail|required|integer|min:1|max:100',
            'eventID'=>'bail|required|numeric|min:0|exists:events,id',
            'value'=>'bail|required|numeric|min:0',
        ];
    }
    public function attributes()
    {
        return [
            'numberPasses'=>'Number',
            'eventID'=>'Event',
            'value'=>'Value of Pass',
        ];
    }

    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
