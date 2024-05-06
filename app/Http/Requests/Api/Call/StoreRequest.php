<?php

namespace App\Http\Requests\Api\Call;

use App\Http\Requests\Api\APIRequest;

class StoreRequest extends APIRequest
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
            'patient_name' =>'required|min:2|max:100',
            'doctor_id' =>'required|exists:users,id',
            'age' => 'required',
            'phone' =>'required',
            'description' => 'required|min:2',
           
        ];
    }
}
