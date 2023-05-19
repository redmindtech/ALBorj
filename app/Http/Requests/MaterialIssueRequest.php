<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialIssueRequest extends FormRequest
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
            'location' => 'required',
            'issue_date' => 'required',
            'issue_ref_no' => 'required',
            'firstname' => 'required',
            'project_name'=>'required',
            'type'=>'required',
    ];
    }
    public function messages(){
        return [
            'location.required' => 'The Location is required.',
            'issue_date.required' => 'The Item Issue Date is required.',
            'issue_ref_no.required' => 'The Issue Ref No is required.',
            'firstname.required' => 'The Receiving Employee is required.',
            'project_name.required'=>'The Project Name is required',
            'type.required'=>'The Type is required',


        ];
    }
}