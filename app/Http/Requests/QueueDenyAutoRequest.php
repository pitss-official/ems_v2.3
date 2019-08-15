<?php

namespace App\Http\Requests;

use App\Queue;
use App\System;
use Illuminate\Foundation\Http\FormRequest;

class QueueDenyAutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('denyAuto',Queue::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'=>'bail|required|numeric|min:0|exists:queues,id',
            'approvalRemarks'=>'bail|required|string|min:2|max:255',
        ];
    }
    public function attributes()
    {
        return [
            'id'=>'Queue ID',
            'approvalRemarks'=>'Remarks',
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
