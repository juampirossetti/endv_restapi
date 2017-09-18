<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

//use Illuminate\Foundation\Http\FormRequest;

class CreateMeetingRoomRequest extends ApiRequest
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
            'meeting_room' => 'required|array',
            'meeting_room.event_type' => 'numeric|min:0|max:3|required',
            'event' => 'required|array',
            'event.date' => 'date_format:Y-m-d|required',
            'event.from' => 'required|date_format:H:i',
            'event.until' => 'required|date_format:H:i',
            'event.description' => 'string|nullable',
        ];
    }
}