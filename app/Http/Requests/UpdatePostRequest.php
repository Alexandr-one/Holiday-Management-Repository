<?php

namespace App\Http\Requests;

use App\Classes\UserRolesEnum;
use App\Classes\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role === UserRolesEnum::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'name_parent_case' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => trans('validation.user.id.required'),
            'id.numeric' => trans('validation.user.id.numeric'),
            'name.required' => trans('validation.post.name.required'),
            'name.string' => trans('validation.post.name.string'),
            'name_parent_case.required' => trans('validation.name.name_parent_case.required'),
            'name_parent_case.string' => trans('validation.name.name_parent_case.string'),
        ];
    }
}
