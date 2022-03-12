<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlockUserRequest extends FormRequest
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
            'blocked_reason' => 'required',
            'user_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'blocked_reason.required' => trans('validation.user.block_reason.required'),
            'user_id.required' => trans('validation.user.user_id.required'),
        ];
    }
}
