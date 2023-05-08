<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
            'project_id' => 'required',
            'reference_date' => 'required',
            'purchase_type' => 'required',
        ];
    }

    public function messages(){
        return [
            'project_id.required' => 'The Project Name is required.',
            'reference_date.required' => 'The Reference Date is required',
            'purchase_type.required' => 'The Purchase Type is required.'
        ];
    }
}
