<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

//use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingRoomRequest extends ApiRequest
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
            'meeting_room' => 'sometimes|array',
            'meeting_room.event_type' => 'numeric|min:0|max:3|sometimes',
            'event' => 'sometimes|array',
            'event.date' => 'date_format:Y-m-d|sometimes',
            'event.from' => 'sometimes|date_format:H:i',
            'event.until' => 'sometimes|date_format:H:i',
            'event.description' => 'string|nullable',
        ];
    }
}