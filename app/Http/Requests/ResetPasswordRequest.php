<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required|min:6|same:password_confirm|required_with:password_confirm',
            'password_confirm' => 'required',
            'code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => trans('validation.password.required'),
            'password_confirm.required' => trans('validation.password_confirm.required'),
            'code.required' => trans('validation.code.required'),
            'password.same' => trans('validation.password.same:password_confirm'),
            'password.min' => trans('validation.password.min'),
        ];
    }
}
