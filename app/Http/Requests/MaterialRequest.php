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
            'date'=> 'required',
            'purchase_type' => 'required',
            'project_id' => 'required',
            'project_name' => 'required',
            'firstname'=>'required',
            'user_id'=> 'required',
           
           
        ];
    }

    public function messages(){
        return [
            'date.required'=>'The date is required',
            'purchase_type.required' => 'The Purchase Type is required.',
            'project_id.required' => 'Please Enter Valid Project Name ',
            'project_name.required' => 'The Project Name is required.',
            'user_id.required'=>'The Employee Name is required.'
       
        ];
    }
}
