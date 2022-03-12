<?php

namespace App\Http\Requests;

use App\Classes\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            'fio' => 'required|string',
            'fio_parent_case' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'fio.required' => trans('validation.FIO.required'),
            'fio.string' => trans('validation.FIO.string'),
            'fio_parent_case.required' => trans('validation.FIO_parent_case.required'),
            'fio_parent_case.string' => trans('validation.FIO_parent_case.string'),
            'address|required' => trans('validation.address.required'),
            'email|required' => trans('validation.email.required'),
            'email|email' => trans('validation.email.email'),
        ];
    }

}
