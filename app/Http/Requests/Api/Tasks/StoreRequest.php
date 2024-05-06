<?php

namespace App\Http\Requests\Api\Tasks;

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
            'user_id' => 'required|exists:users,id',
            'task_name' => 'required|min:2|max:150',
            'description' => 'required|min:2',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
