<?php

namespace App\Http\Requests;

use App\System;
use App\Team;
use Illuminate\Foundation\Http\FormRequest;

class CreateTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('create',Team::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teamName' => 'required|min:5|unique:teams,name,eventID',
            'eventID' => 'bail|required|integer|min:0|exists:events,id',
            'description' => 'string|min:5',
        ];
    }
    public function attributes()
    {
        return [
            'teamName' => 'Team Name',
            'eventID' => 'Event',
            'description' => 'Team Description',
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
