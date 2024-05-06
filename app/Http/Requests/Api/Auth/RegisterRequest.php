<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends APIRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'specialist' =>  'required',
            'birthday' => 'required',
            'status' =>  'required',
            'type' =>  'required',
            'address' =>  'required',
            'email' =>  'required|unique:users,email',
            'mobile' =>  'required',
            'password' => 'required',
        ];
    }
}
