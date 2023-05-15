<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodReceivingNoteRequest extends FormRequest
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
            'name' => 'required|regex:/^[A-Z a-z]+$/',
            'grn_date'=>'required',
            'project_name'=>'required',
            'grn_purchase_type'=>'required',
            'po_no'=>'required',
            'po_date'=>'required'
        ];
    }
    public function messages()
    {
        return
        [
            'name.required' => 'The Supplier Name is required.',
            'name.regex' => 'The Supplier Name allows only alphabets.',
            'grn_date.required'=>'The GRN Invoice / Receive date is required',
            'project_name.required'=>'The Project Name is required',
            'grn_purchase_type.required'=>'The Project Type is required',
            'po_no.required'=>'The project code is required',
            'po_date.required'=>'The project date is required',

            
        ];
    }
}
