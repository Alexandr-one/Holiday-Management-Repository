<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email' => 'required|email',
            'post_id' => 'required',
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('validation.email.required'),
            'email.email' => trans('validation.email.email'),
            'post_id.required' => trans('validation.post_id.required'),
            'role.required' => trans('validation.user.status.required'),
        ];
    }
}
