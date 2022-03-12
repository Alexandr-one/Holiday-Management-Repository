<?php

namespace App\Http\Requests;

use App\Classes\UserRolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSystemParamsRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'director_id' => ['required', 'exists:users,id'],
            'max_duration_of_vacation' => ['required', 'numeric'],
            'min_duration_of_vacation' => ['required', 'numeric']
        ];
    }

    public function messages()
    {
        return [
            'name.required'                     => trans('validation.organization.name.required'),
            'director_id.required'              => trans('validation.organization.director_id.required'),
            'max_duration_of_vacation.required' => trans('validation.organization.max_duration_of_vacation.required'),
            'min_duration_of_vacation.required' => trans('validation.organization.min_duration_of_vacation.required'),
        ];
    }

}
