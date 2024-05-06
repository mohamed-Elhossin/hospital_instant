<?php

namespace App\Http\Requests\Api\Measurements;

use App\Http\Requests\Api\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

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
            'call_id' =>'required|exists:calls,id',
            'blood_pressure' =>'required',
            'sugar_analysis' =>'required',
            'note' =>'required|min:2',
            'status' => 'required',
        ];
    }
}
