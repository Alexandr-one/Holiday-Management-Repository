<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
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
            'status' => 'required',
            'id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => trans('validation.user.status.required'),
            'id.required' => trans('validation.user.id.required'),
        ];
    }
}
