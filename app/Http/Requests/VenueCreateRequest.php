<?php

namespace App\Http\Requests;

use App\System;
use App\Venue;
use Illuminate\Foundation\Http\FormRequest;

class VenueCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return $this->user('api')->can('create',Venue::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'bail|required|integer|between:1,10',
            'name' => 'bail|required|string|min:1|max:90',
            'primaryAddressLine' => 'bail|required|string|min:1|max:90',
            'secondaryAddressLine' => 'nullable|string|min:1|max:90',
            'tertiaryAddressLine' => 'nullable|string|min:1|max:90',
            'shortAddress' => 'bail|required|string|min:1|max:50',
            'capacity' => 'bail|required|integer|min:1',
            'price' => 'bail|required|numeric|min:0',
            'coordinatorsRequired' => 'bail|required|integer|min:1'
        ];
    }
    public function attributes()
    {
        return [
            'type' => 'venue type',
            'name' => 'venue name',
            'primaryAddressLine' => 'Address Line 1',
            'secondaryAddressLine' => 'Address Line 2',
            'tertiaryAddressLine' => 'Address Line 3',
            'shortAddress' => 'Short Address',
            'capacity' => 'capacity',
            'price' => 'price',
            'coordinatorsRequired' => 'Number of Coordinators'
        ];
    }
    public function validatedAndSanitized(array $skippedKeys=[])
    {
        return System::sanitize($this->validated(),$skippedKeys);
    }
}
