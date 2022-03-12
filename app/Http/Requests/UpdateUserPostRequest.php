<?php

namespace App\Http\Requests;

use App\Classes\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserPostRequest extends FormRequest
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
            'user_id' => 'required',
            'position_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => trans('validation.user.user_id.required'),
            'position_id.required' => trans('validation.post_id.required'),
        ];

    }
}
