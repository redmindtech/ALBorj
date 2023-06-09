<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpensesCategoryRequest extends FormRequest
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
        return
        [
            'category_name' => 'required|max:30|regex:/^[a-z A-Z]+$/'

        ];
    }
    public function messages()
    {
        return
        [
            'category_name.required' => 'The Category Name is required.'
        ];
    }
}