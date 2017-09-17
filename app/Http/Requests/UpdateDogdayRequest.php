<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

//use Illuminate\Foundation\Http\FormRequest;

class UpdateDogdayRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dogday' => 'sometimes|array',
            'dogday.pet_name' => 'sometimes|string',
            'event' => 'sometimes|array',
            'event.date' => 'sometimes|date_format:Y-m-d',
            'event.from' => 'sometimes|date_format:H:i',
            'event.until' => 'sometimes|date_format:H:i',
            'event.description' => 'string|nullable',
        ];
    }
}
