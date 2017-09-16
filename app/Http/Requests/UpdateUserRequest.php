<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

//use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends ApiRequest
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
        $user = $this->route('user');
        
        return [
            'user' => 'required|array',
            'user.name' => 'sometimes|string',
            'user.surname' => 'sometimes|string',
            'user.email' => 'sometimes|email|unique:users,email,'.$user->id
        ];
    }
}