<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'name' => 'required',
            'name_parent_case' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.post.name.required'),
            'name_parent_case.required' => trans('validation.post.name_parent_case.required'),
        ];
    }
}
